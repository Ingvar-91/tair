<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Site\Controller;
use Auth;
use Illuminate\Http\Request;
use App\Validation\Auth\AuthValidation;

class LoginController extends Controller {
    
    use AuthValidation;//трейт, содержит методы валидации для формы регистрации и авторизации

    protected $redirectTo = '/login';
    const tmpl = 'auth/login';

    public function __construct() {
        parent::__construct();
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function index() {
        return view(self::tmpl, $this->data);
    }

    //разлогиниться
    public function logout() {
        Auth::logout();
        return back();
    }

    //авторизация юзера
    public function login(Request $request) {
        $validator = $this->validLogin($request);
        $auth = Auth::attempt(['email' => mb_strtolower($request->email, 'UTF-8'), 'password' => mb_strtolower($request->password, 'UTF-8')], $request->remember ? true : false);
        
        if($validator->fails()){
            return redirect('/login')->withErrors($validator->errors()->getMessages());
        }
        
        if($auth == true){
            return back();
        } 
        else{//если аторизация не прошла
            $validator->errors()->add('password', 'Ошибка, возможно вы ввели неверный пароль.');
            return redirect('/login')->withErrors($validator->errors()->getMessages());
            //$this->throwValidationException($request, $validator);
        }
    }
}