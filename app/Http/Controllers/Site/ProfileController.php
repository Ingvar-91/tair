<?php
namespace App\Http\Controllers\Site;

use App\Http\Controllers\Site\Controller;
use Illuminate\Http\Request;

use App\Http\Models\Site\Users;
use App\Http\Models\Site\Reviews;

use App\Files\UploadImage;
use App\Validation\Site\UsersValidation;

use Auth;
use Redirect;

class ProfileController extends Controller{
    
    use UsersValidation;
    use UploadImage;

    const tmpl = 'site/profile/';

    public function index(Request $request){
        
        return view(self::tmpl.'index', $this->data);
    }
    
    public function getAllReviewsProductsUser(Request $request){
        $this->data['reviews'] = Reviews::getAllReviewsProduct(false, false, Auth::user()->id);
        return view(self::tmpl.'reviews-product', $this->data);
    }
    
    public function getAllReviewsShopsUser(Request $request){
        $this->data['reviews'] = Reviews::getAllReviewsShop(false, false, Auth::user()->id);
        return view(self::tmpl.'reviews-shop', $this->data);
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