<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Site\Controller;
use Illuminate\Http\Request;
use Auth;
use Mail;

use App\Validation\Auth\AuthValidation;
use App\Http\Models\Site\Users;
use App\Files\UploadImage;
use App\Jobs\SendEmailRegister;

class RegisterController extends Controller {
    
    use AuthValidation;
    use UploadImage;

    protected $redirectTo = '/';
	
    const tmpl = 'auth/';

    public function index(){
        return view(self::tmpl.'register', $this->data);
    }

    //создать юзера
    public function createUser(Request $request) {
        $validator = $this->validReg($request); //валидируем данные
        
        if($validator and $validator->fails()){
            return redirect('/register')->withErrors($validator->errors()->getMessages());
        }
        
        //если загружена аватарка
        $nameImage = '';
        if($request->hasFile('image')){
            //загружаем аватарку на сервер
            $nameImage = $this->uploadImage($request->file('image'));
        }
        
        $array = (object)[
            'verification_token' => str_random(32),
            'email' => mb_strtolower($request->email, 'UTF-8'),
            'password' => mb_strtolower($request->password, 'UTF-8')
        ];
        
        $id = Users::add($request, $nameImage, $array->verification_token);//создаем пользователя
        if($id){//если пользователь создан успешно
            $array->id = $id;
            
            //отправляем ему письмо на почту для верификации
            $this->dispatch(new SendEmailRegister($array));
            //$this->sendMail($array);

            //входим в аккаунт пользователя
            $auth = Auth::attempt(['email' => $request->email, 'password' => $request->password], true);
            //пишем юзеру сообщение о том все впорядке
            //return redirect('/messages')->with('message-success', 'Вам на почту были высланы инструкции для завершения регистрации');
            return redirect('/messages')->with('message-success', 'Вы были успешно зарегистрированы. Вы можете перейти на <a href="'.Route('home').'" class="link">главную</a> страницу сайта. Либо на <a href="'.Route('profile').'" class="link">страницу профиля</a>.');
        }
        else {//если нет
            return redirect('/register')->with('message-error', 'Произошла ошибка при регистрации');
        } 
    }
    
    //верификация пользователя
    public function verification(Request $request){
        $id = (int)$request->id;
        if((!$id) && (!$request->verification_token)) return false;
        $user = Users::getDataById($id);
        if($user->verification_token == $request->verification_token){//если токены совпадают
            $update = Users::verifyUser($id);//верифицируем юзера
            if($update){
                if(Auth::check()){
                    Auth::user()->verification = 1;
                }
                return redirect('/messages')->with('message-success', 'Вы были успешно верифицированы');
            }
            else return redirect('/messages')->with('message-error', 'Ошибка верификации пользователя, вероятно пользователь уже подтвердил свой E-mail');
        }
    }
    
    //форма отправки письма для верификации пользователя
    public function confirmMailForm(Request $request){
        return view(self::tmpl.'confirmMailForm', $this->data);
    }
    
    //отправить письмо юзеру для подтверждения регистрации
    public function sendMailConfirm(Request $request){
        $this->validCaptcha($request);
        
        //$this->dispatch(new SendVarifiEmail($array));
        $this->sendMail(Auth::user());
        
        return redirect('/messages')->with('message-success', 'Письмо отправленно, проверьте ваш почту.');
    }
    
    private function sendMail($data){
        Mail::send('emails/register', array(
            'nameSite' => config('app.name'), 
            'verification_token' => $data->verification_token, 
            'email' => $data->email,
            'password' => $data->password,
            'id' => $data->id,
        ), function($message) use ($data){
            $message->from(config('mail.from.address'));//от кого
            $message->to(trim($data->email));//кому отправляем
            $message->subject('Завершение регистрации');//тема письма
        });
    }
}