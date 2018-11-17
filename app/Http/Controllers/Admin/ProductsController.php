<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;

use App\Http\Models\Admin\Products;
use App\Http\Models\Admin\Chars;
use App\Http\Models\Admin\CharsProducts;
use App\Http\Models\Admin\Shops;
use App\Http\Models\Admin\Posts;
use App\Http\Models\Admin\ProductCategories;

use Redirect;
use Auth;

use App\Files\UploadImages;

use Illuminate\Support\Facades\Cache;

class ProductsController extends Controller {
    
    use UploadImages;
    
    const tmpl = 'admin/products/';
    
    private $categoriesId;
    
    public function __construct(){
        parent::__construct();
        
        $this->categoriesId = collect();
    }
     
    public function index(Request $request) {
        if ($request->ajax()){
            $fields = $this->getFieldsDataTables($request); //получаем значения полей от плагина dataTables при ajax запросе
            $items = Products::getDataForDataTables($fields, $request->shop_type); //получаем данные для DataTables

            if ($items) {
                foreach ($items as $item) {
                    $item->price = view(self::tmpl . 'data-table-price', ['item' => $item])->render();
                    $item->image = view(self::tmpl . 'data-table-image', ['images' => $item->images])->render();
                    $item->actions = view(self::tmpl . 'data-table-action', ['id' => $item->id])->render();
                    $item->status = view(self::tmpl . 'data-table-status', ['status' => $item->status])->render();
                }
                $recordsTotal = Products::queryWhere(false, $fields, $request->shop_type)->count();
                if ($request->input('search')['value']) $recordsFiltered = $items->count();
                else $recordsFiltered = $recordsTotal;
                return response()->json([
                    'data' => $items,
                    'recordsTotal' => $recordsTotal,
                    'recordsFiltered' => $recordsFiltered
                ]);
            }
        } else {
            $this->data['shops'] = Shops::getAll();
            
            $minutes = 525600;// 1 год
            $this->data['categories'] = Cache::remember(config('cache.member.categories.admin_products'), $minutes, function () {
                return $this->buildTree(ProductCategories::index());
            });
        }
        
        return view(self::tmpl . 'index', $this->data);
    }
    
    //
    public function remove(Request $request){
        if ($request->ajax()) {
            //$product = Products::getById($request->id);
            $result = Products::remove($request->id);
            /*if($result){
                $this->removeImages($product->images, 'products');
            }*/
            return response()->json(['error' => empty($result)]);
        }
    }
    
    //форма добавления новой записи
    public function addForm(Request $request){
        $this->data['shops'] = Shops::getAll();
        return view(self::tmpl.'add', $this->data);
    }
    
    public function uploadFiles(Request $request){
        if($request->hasFile('file')){
            $fileName = $this->UploadImages($request->file, 'products', 1, 'imposition');
            return response()->json(['fileName' => $fileName]);
        }
    }
    
    public function removeImageProduct(Request $request){
        if($request->ajax()){
            $result = $this->removeImages($request->image, 'products');
            return response()->json(['error' => empty($result)]);
        }
    }
    
    //добавить запись
    public function add(Request $request){       
        if($request->ajax()){
            $chars = json_decode($request->chars);
            $images = implode('|', json_decode($request->images));
            
            try{
                \DB::beginTransaction();//начало транзакции
            
                //товар
                $id = Products::add($request, $images);
                
                //характеристики
                $charsInsert = [];
                foreach ($chars as $array) {
                    foreach ($array as $charId) {
                        $charsInsert[] = [
                            'char_id' => $charId,
                            'product_id' => $id
                        ];
                    }
                }
                
                CharsProducts::addChars($charsInsert);

                \DB::commit();//конец транзакции
                return response()->json(['error' => false]);
            }
            catch (\Exception $e){
                \DB::rollback();//Отмена транзакции и изменений, вызванных её выполнением
                return response()->json(['error' => true]);
            }
        }
    }
    
    //получить последний товар
    public function getLastProduct(Request $request){
        if ($request->ajax()) {
            $record = Products::getLastProduct($request->id);
            return response()->json(['error' => false, 'response' => $record]);
        }
    }
    
    public function editStatus(Request $request){
        return response()->json(['error' => empty(Products::editStatus($request))]);
    }
    
    //форма редактирования записи
    public function editForm(Request $request){
        $this->data['product'] = Products::getById($request->id);
        $this->data['category'] = ProductCategories::getById($this->data['product']->category_id);
        
        $shops = Shops::getAll();
        foreach($shops as $shop){
            if($shop->id == $this->data['product']->shop_id) $shop->check = true;
        }
        $this->data['shops'] = $shops;
        
        //получить все id родителей, вплоть до самого первого
        $this->getCategoriesId($this->data['product']->category_id);
        //получить характеристики
        $chars = collect([Chars::index($request), Chars::getByCategoryIdIn($this->categoriesId)]);
        $chars = $chars->collapse();
        
        //
        $charsProducts = CharsProducts::getByProductId($request->id);
        foreach($chars as $char){
            if($char->parent_id == 0) continue;
            $check = $charsProducts->where('char_id', $char->id)->count();
            if($check){
                $char->check = true;
            }
        }
        $this->data['chars'] = $this->buildTree($chars);
        
        return view(self::tmpl.'edit', $this->data);
    }
    
    //фома добаление копии выбранного товара
    public function addFormCopy(Request $request){
        $this->data['product'] = Products::getById($request->id);
        $this->data['category'] = ProductCategories::getById($this->data['product']->category_id);
        
        $this->data['product']->date_remove = null;
        $this->data['product']->discount = null;
        $this->data['product']->start_discount = null;
        $this->data['product']->end_discount = null;
        
        $shops = Shops::getAll();
        foreach($shops as $shop){
            if($shop->id == $this->data['product']->shop_id) $shop->check = true;
        }
        $this->data['shops'] = $shops;
        
        //получить все id родителей, вплоть до самого первого
        $this->getCategoriesId($this->data['product']->category_id);
        //получить характеристики
        $chars = collect([Chars::index($request), Chars::getByCategoryIdIn($this->categoriesId)]);
        $chars = $chars->collapse();
        
        //
        $charsProducts = CharsProducts::getByProductId($request->id);
        foreach($chars as $char){
            if($char->parent_id == 0) continue;
            $check = $charsProducts->where('char_id', $char->id)->count();
            if($check){
                $char->check = true;
            }
        }
        $this->data['chars'] = $this->buildTree($chars);
        return view(self::tmpl.'add-copy', $this->data);
    }
    
    public function addCopy(Request $request){       
        if($request->ajax()){
            $chars = json_decode($request->chars);
            $images = implode('|', json_decode($request->images));
            
            try{
                \DB::beginTransaction();//начало транзакции
            
                //товар
                $id = Products::add($request, $images);
                
                //характеристики
                $charsInsert = [];
                foreach ($chars as $array) {
                    foreach ($array as $charId) {
                        $charsInsert[] = [
                            'char_id' => $charId,
                            'product_id' => $id
                        ];
                    }
                }
                
                CharsProducts::addChars($charsInsert);

                \DB::commit();//конец транзакции
                return response()->json(['error' => false]);
            }
            catch (\Exception $e){
                \DB::rollback();//Отмена транзакции и изменений, вызванных её выполнением
                return response()->json(['error' => true]);
            }
        }
    }
    
    //сохранить изменения записи
    public function edit(Request $request){
        if ($request->ajax()){
            $chars = json_decode($request->chars);
            $images = implode('|', json_decode($request->images));
            
            try{
                \DB::beginTransaction();//начало транзакции

                $update = Products::edit($request, $images);
                
                $this->relationCharsProduct($chars, $request->product_id);

                \DB::commit();//конец транзакции
                return response()->json(['error' => false]);
            }
            catch (\Exception $e){
                print_r($e->getMessage());
                \DB::rollback();//Отмена транзакции и изменений, вызванных её выполнением
                return response()->json(['error' => true]);
            }
        }
    }
    
    private function getCategoriesId($category_id = false){
        $category = ProductCategories::getById($category_id);
        if($category->parent_id){
            $this->categoriesId->push($category->parent_id);
            $this->getCategoriesId($category->parent_id);
        }
    }
    
    private function relationCharsProduct($charsArray, $product_id){
        $charsObj = collect();
        foreach ($charsArray as $array) {
            foreach ($array as $id) {
                $charsObj->push((object)[
                    'char_id' => $id,
                    'product_id' => $product_id
                ]);
            }
        }
        
        $charsProducts = $charsObj->pluck('char_id');
        $relations = CharsProducts::getByProductId($product_id);
        $relationsPluck = $relations->pluck('char_id');
        //вычисляем расхождения массивов для удаления
        $removeRelations = $relationsPluck->diff($charsProducts);
        //вычисляем расхождения массивов для добавления
        $addRelations = $charsProducts->diff($relationsPluck);
        
        //получаем id для удаления записей
        $removeId = $relations->whereIn('char_id', $removeRelations)->pluck('id');
        //удаляем
        CharsProducts::removeInById($removeId);
        
        //добавляем
        $charsInsert = [];
        foreach ($addRelations as $charId) {
            $charsInsert[] = [
                'char_id' => $charId,
                'product_id' => $product_id
            ];
        }
        CharsProducts::addChars($charsInsert);
    }
    
    
    //получить информацию о товаре
    public function getProductInfo(Request $request){
        $this->data['product'] = Products::getById($request->id);
        $this->data['path'] = '/'.config('filesystems.products.path');
        
        /*
        $shops = Shops::getAll();
        foreach($shops as $shop){
            if($shop->id == $this->data['product']->shop_id) $shop->check = true;
        }
        $this->data['shops'] = $shops;
        $this->data['tradeOffers'] = $this->buildTree($tradeOffers);
        */
        return response()->json(['data' => $this->data]);
    }
}
