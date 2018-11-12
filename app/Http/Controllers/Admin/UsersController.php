<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;
use Redirect;
use Auth;

use App\Http\Models\Admin\Users;
use App\Http\Models\Admin\Shops;
use App\Http\Models\Admin\UsersShops;
use App\Files\UploadImage;
use App\Validation\Admin\UserValidation;

use App\Helpers\Helper;

class UsersController extends Controller {
    
    use UserValidation;
    use UploadImage;
    
    const tmpl = 'admin/users/';

    public function index(Request $request) {
        if ($request->ajax()) {
            $fields = $this->getFieldsDataTables($request);
            //получаем данные для DataTables
            $items = Users::getDataForDataTables($fields);
            if($items){
                foreach($items as $item){
                    $item->image = view(self::tmpl.'data-table-image', ['image' => $item->image])->render();
                    $item->actions = view(self::tmpl.'data-table-action', ['id' => $item->id])->render();
                }
                $recordsTotal = Users::queryWhere(false, $fields)->count();
                if($request->input('search')['value']) $recordsFiltered = $items->count();
                else $recordsFiltered = $recordsTotal;
                return response()->json(
                    [
                        'data' => $items,
                        'recordsTotal' => $recordsTotal,
                        'recordsFiltered' => $recordsFiltered
                    ]
                );
            } 
        }
        return view(self::tmpl . 'index', $this->data);
    }
    
    //страница добавления записей
    public function addForm(){
        $this->data['shops'] = Shops::getAll();
        return view(self::tmpl . 'add', $this->data);
    }
    
    //добавление записей
    public function add(Request $request){
        $this->validCreateUser($request);
        //если загружена аватарка
        $nameImage = '';
        if($request->hasFile('image')){
            //загружаем аватарку на сервер
            $nameImage = $this->uploadImage($request->file('image'), 'avatars');
        }
        $id = Users::add($request, $nameImage);
        
        if($id){
            UsersShops::addShops($request->users_shops, $id);
            
            return Redirect::back()->with('message-success', 'Данные успешно добавлены.');
        }
        else return Redirect::back()->with('message-error', 'Произошла ошибка при добавлении данных.');
    }
    
    //страница редактирования записей
    public function editForm(Request $request){
        $this->data['user'] = Users::getById($request->id);
        
        //отмечаем магазины к которым юзер имеет доступ
        $shops = Shops::getAll();
        $user_shops = UsersShops::getAllRelation($request->id);
        foreach($shops as $shop){
            $shop->check = false;
            foreach($user_shops as $user_shop){
                if($shop->id == $user_shop->shop_id) $shop->check = true;
            }
        }
        $this->data['shops'] = $shops;
        //
        return view(self::tmpl . 'edit', $this->data);
    }
    
    public function edit(Request $request){
        $user = Users::getById($request->id);
        $this->validEditUser($request, $user);
        
        //
        $users_shops = collect($request->users_shops);
        $relations = UsersShops::getAllRelation($request->id);
        
        $relationsPluck = $relations->pluck('shop_id');
        //вычисляем расхождения массивов для удаления
        $removeRelations = $relationsPluck->diff($users_shops);
        //вычисляем расхождения массивов для добавления
        $addRelations = $users_shops->diff($relationsPluck);
        $removeArrIds = [];
        foreach($removeRelations as $id){
            foreach($relations as $relation){
                if($id == $relation->shop_id) $removeArrIds[] = $relation->id;
            }
        }
        
        //если загружена аватарка
        $nameImage = $user->image;
        if($request->hasFile('image')){
            //загружаем аватарку на сервер
            $nameImage = $this->uploadImage($request->file('image'), 'avatars');
            //Удаляем старую аватарку
            if($nameImage) $this->removeImage($user->image, 'avatars');
        }
        $update = Users::edit($request, $nameImage);
        if($update){
            
            UsersShops::addShops($addRelations, $request->id);
            UsersShops::removeInId($removeArrIds);
            
            return redirect()->back()->with('message-success', 'Данные успешно обновлены.');
        }
        return redirect()->back()->with('message-error', 'Произошла ошибка при обновлении данных.');
    }
    
    //удаление записей
    public function remove(Request $request){
        $user = Users::getById($request);//получаем юзера
        $result = Users::remove($request);//удаляем юзера
        if($result) $this->removeImage($user->image, 'avatars');//если все нормально, удаляем его аватарку
        
        if ($request->ajax()) {
            return response()->json(['error' => empty($result)]);
        }
    }
    
}
