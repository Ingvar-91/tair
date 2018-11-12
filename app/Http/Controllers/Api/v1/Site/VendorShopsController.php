<?php

namespace App\Http\Controllers\Api\v1\Site;

use App\Http\Controllers\Site\Controller;
use Illuminate\Http\Request;
use Auth;

use App\Http\Models\Site\UsersShops;
use App\Http\Models\Site\Shops;
use App\Http\Models\Site\ShopCategories;
use App\Http\Models\Admin\ShopCategoriesRelations;

use App\Files\UploadImages;

use App\Helpers\Helper;

class VendorShopsController extends Controller {
    
    use UploadImages;

    const tmpl = 'site/vendor-shops/';
    
    public function index(Request $request){
        if($request->ajax()){
            $response = [];
            $shops = UsersShops::getShopsUser(Auth::user()->id);
            foreach ($shops as $shop) {
                if(Helper::getImg($shop->shop_images, 'shops', 'small')){
                    $shop->shop_images = Helper::getImg($shop->shop_images, 'shops', 'small');
                }
                else{
                    $shop->shop_images = '/img/no-image-16x9.jpg';
                }
            }
            $response['shops'] = $shops;
            return response()->json($response);
        }
        
        $this->data['shops'] = UsersShops::getShopsUser(Auth::user()->id);
        return view(self::tmpl.'index', $this->data);
    }
    
    /*public function addForm(){
        $this->data['shop_categories'] = ShopCategories::getAll();
        return view(self::tmpl.'add', $this->data);
    }*/
    
    //добавить запись
    /*public function add(Request $request){
        //загружаем изображения
        $fileNames = '';
        if($request->hasFile('images')){
            $fileNames = $this->uploadImages($request->file('images'), 'shops');
        }
        $id = Shops::add($request, $fileNames);
        
        if($id){
            UsersShops::addShop(Auth::user()->id, $id);
            ShopCategoriesRelations::add($request->shop_categories_relations, $id);
            return redirect()->back()->with('message-success', 'Данные успешно добавлены.');
        }
        return redirect()->back()->with('message-error', 'Произошла ошибка при добавлении данных.');
    }*/
    
    //форма редактирования записи
    public function editForm(Request $request){
        $this->data['shop'] = Shops::getById($request->id);
        $shop_categories = ShopCategories::getAll();
        $relations = ShopCategoriesRelations::getAllRelation($request);
        
        foreach($shop_categories as $shop_category){
            $shop_category->check = false;
            foreach($relations as $relation){
                if($shop_category->id == $relation->shop_category_id) $shop_category->check = true;
            }
        }
        $this->data['shop_categories'] = $shop_categories;
        
        return view(self::tmpl.'edit', $this->data);
    }
    
    //сохранить изменения записи
    public function edit(Request $request){
        /*
        //редактирование категорий
        $shop_categories_relations = collect($request->shop_categories_relations);
        $relations = ShopCategoriesRelations::getAllRelation($request);
        $relationsPluck = $relations->pluck('shop_category_id');
        //вычисляем расхождения массивов для удаления
        $removeRelations = $relationsPluck->diff($shop_categories_relations);
        //вычисляем расхождения массивов для добавления
        $addRelations = $shop_categories_relations->diff($relationsPluck);
        $removeArrIds = [];
        foreach($removeRelations as $id){
            foreach($relations as $relation){
                if($id == $relation->shop_category_id) $removeArrIds[] = $relation->id;
            }
        }
        
        //загружаем новые изображения
        $fileNames = '';
        if($request->hasFile('images')){
            $fileNames = $this->uploadImages($request->file('images'), 'shops');
            $data = Shops::getById($request->id);
            if($fileNames) $this->removeImages($data->images, 'shops');
        }
        */
        
        //обновляем
        //$update = Shops::edit($request, $fileNames);
        $update = Shops::edit($request);
        if($update){
            
            //ShopCategoriesRelations::add($addRelations, $request->id);
            //ShopCategoriesRelations::removeInId($removeArrIds);
            
            //return back()->with('message-success', 'Данные успешно обновлены, магазин будет вновь доступен после проверки');
            return back()->with('message-success', 'Данные успешно обновлены');
        }
        
        return back()->with('message-error', 'Произошла ошибка при обновлении данных.');
    }
    
}
