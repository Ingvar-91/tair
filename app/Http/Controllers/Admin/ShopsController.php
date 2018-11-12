<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;

use Auth;
use App\Http\Models\Admin\Shops;
use App\Http\Models\Admin\ShopCategories;
use App\Http\Models\Admin\ShopCategoriesRelations;
use App\Http\Models\Admin\ShopsType;
use App\Http\Models\Admin\PaymentMethods;
use App\Http\Models\Admin\DeliveryMethods;

use App\Files\UploadImages;
use App\Files\UploadImage;

class ShopsController extends Controller {
    
    use UploadImages;
    use UploadImage;

    const tmpl = 'admin/shops/'; //путь до шаблонов
    
    public function index(Request $request) {
        if ($request->ajax()) {
            $fields = $this->getFieldsDataTables($request); //получаем значения полей от плагина dataTables при ajax запросе
            $items = Shops::getDataForDataTables($fields); //получаем данные для DataTables
            if ($items) {
                foreach ($items as $item) {
                    $item->actions = view(self::tmpl . 'data-table-action', ['id' => $item->id])->render();
                    $item->image = view(self::tmpl . 'data-table-image', ['image' => explode('|', $item->images)[0]])->render();
                }
                $recordsTotal = Shops::queryWhere(false, $fields)->count();
                if ($request->input('search')['value']) $recordsFiltered = $items->count();
                else $recordsFiltered = $recordsTotal;
                return response()->json([
                    'data' => $items,
                    'recordsTotal' => $recordsTotal,
                    'recordsFiltered' => $recordsFiltered
                ]);
            }
        }
        
        return view(self::tmpl . 'index', $this->data);
    }
    
    //форма добавления новой записи
    public function addForm(){
        $this->data['shop_categories'] = ShopCategories::getAll();
        $this->data['shop_type'] = ShopsType::getAll();
        $this->data['payment_methods'] = PaymentMethods::getAll();//Способы оплаты
        $this->data['delivery_methods'] = DeliveryMethods::getAll();//Способы доставки
        
        return view(self::tmpl.'add', $this->data);
    }
    
    //добавить запись
    public function add(Request $request){
        //загружаем изображения
        $fileNames = '';
        if($request->hasFile('images')){
            $fileNames = $this->uploadImages($request->file('images'), 'shops');
        }
        
        $preview_frontpage = '';
        if($request->hasFile('preview_frontpage')){
            $preview_frontpage = $this->uploadImage($request->file('preview_frontpage'), 'preview_frontpage', 'resize');
        }
        
        $logo = '';
        if($request->hasFile('logo')){
            $logo = $this->uploadImage($request->file('logo'), 'logo', 'resizeByHeight');
        }
        
        $id = Shops::add($request, $fileNames, $logo, $preview_frontpage);
        
        if($id){
            ShopCategoriesRelations::add($request->shop_categories_relations, $id);
            
            return redirect()->back()->with('message-success', 'Данные успешно добавлены.');
        }
        
        return redirect()->back()->with('message-error', 'Произошла ошибка при добавлении данных.');
    }
    
    //форма редактирования записи
    public function editForm(Request $request){
        $this->data['shop'] = Shops::getById($request->id);
        $this->data['shop_type'] = ShopsType::getAll();
        $this->data['payment_methods'] = PaymentMethods::getAll();//Способы оплаты
        $this->data['delivery_methods'] = DeliveryMethods::getAll();//Способы доставки
        
        $this->data['shop']->payment_methods = collect(unserialize($this->data['shop']->payment_methods));
        $this->data['shop']->delivery_methods = collect(unserialize($this->data['shop']->delivery_methods));
        
        //отмечаем категории к которым относится магазин
        $shop_categories = ShopCategories::getAll();
        $relations = ShopCategoriesRelations::getAllRelation($request);
        foreach($shop_categories as $shop_category){
            $shop_category->check = false;
            foreach($relations as $relation){
                if($shop_category->id == $relation->shop_category_id) $shop_category->check = true;
            }
        }
        $this->data['shop_categories'] = $shop_categories;
        //
        
        return view(self::tmpl.'edit', $this->data);
    }
    
    //сохранить изменения записи
    public function edit(Request $request){
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
        
        $shop = Shops::getById($request->id);
        
        $preview_frontpage = '';
        if($request->hasFile('preview_frontpage')){
            $preview_frontpage = $this->uploadImage($request->file('preview_frontpage'), 'preview_frontpage', 'resize');
            if($preview_frontpage) $this->removeImage($shop->preview_frontpage, 'preview_frontpage', 'resize');
        }
        
        $logo = '';
        if($request->hasFile('logo')){
            $logo = $this->uploadImage($request->file('logo'), 'logo', 'resizeByHeight');
            if($logo) $this->removeImage($shop->logo, 'logo');
        }
        
        //загружаем новые изображения
        $fileNames = '';
        if($request->hasFile('images')){
            $fileNames = $this->uploadImages($request->file('images'), 'shops');
            if($fileNames) $this->removeImages($shop->images, 'shops');
        }
        
        //обновляем
        $update = Shops::edit($request, $fileNames, $logo, $preview_frontpage);
        if($update){
            
            ShopCategoriesRelations::add($addRelations, $request->id);
            ShopCategoriesRelations::removeInId($removeArrIds);
            
            return redirect()->back()->with('message-success', 'Данные успешно обновлены.');
        }
        
        return redirect()->back()->with('message-error', 'Произошла ошибка при обновлении данных.');
    }
    
    public function remove(Request $request){
        if ($request->ajax()) {
            
            $data = Shops::getById($request->id);
            $this->removeImages($data->images, 'shops');
            
            $result = Shops::remove($request);
            return response()->json(['error' => empty($result)]);
        }
    }
    
    public function uploadFiles(Request $request){
        if($request->hasFile('file')){
            //$fileName = $this->UploadImages($request->file, 'shops_gallery', 1, 'imposition');
            $fileName = $this->UploadImages($request->file, 'shops_gallery', 1);
            return response()->json(['fileName' => $fileName]);
        }
    }
    
    public function removeImageProduct(Request $request){
        if($request->ajax()){
            $result = $this->removeImages($request->image, 'shops_gallery');
            return response()->json(['error' => empty($result)]);
        }
    }

}
