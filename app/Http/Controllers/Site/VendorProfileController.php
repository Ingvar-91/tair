<?php
namespace App\Http\Controllers\Site;

use App\Http\Controllers\Site\Controller;
use Illuminate\Http\Request;

use App\Http\Models\Site\Users;
use App\Files\UploadImage;
use App\Validation\Site\UsersValidation;

use Auth;
use Redirect;

class AccountProfileController extends Controller{
    
    use UsersValidation;
    use UploadImage;

    const tmpl = 'site/account-profile/';

    public function index(Request $request){
        
        return view(self::tmpl.'index', $this->data);
    }
    
    public function edit(Request $request){
        $user = Users::getById(Auth::user()->id);
        $this->validEditUser($request, $user);
        //если загружена аватарка
        $nameImage = $user->image;
        if($request->hasFile('image')){
            //загружаем аватарку на сервер
            $nameImage = $this->uploadImage($request->file('image'), 'avatars');
            //Удаляем старую аватарку
            if($nameImage) $this->removeImage($user->image, 'avatars');
        }
        $result = Users::edit($request, $nameImage, Auth::user()->id);
        if($result) return redirect()->back()->with('message-success', 'Данные успешно обновлены.');
        else return redirect()->back()->with('message-error', 'Произошла ошибка при обновлении данных.');
    }

}