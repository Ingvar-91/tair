<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Site\Controller;
use Illuminate\Http\Request;
use Auth;

use App\Http\Models\Site\UsersShops;
use App\Http\Models\Site\Products;
use App\Http\Models\Site\Chars;
use App\Http\Models\Site\CharsProducts;
use App\Http\Models\Site\Shops;
use App\Http\Models\Site\ProductCategories;

use App\Jobs\SendEmailVendorProducts;

use App\Files\UploadImages;

class VendorProductsController extends Controller {
    
    use UploadImages;

    const tmpl = 'site/vendor-products/';
    
    private $categoriesId;
    
    public function __construct(){
        parent::__construct();
        
        $this->categoriesId = collect();
    }
    
    public function index(Request $request) {
        if ($request->ajax()){
            $fields = $this->getFieldsDataTables($request); //получаем значения полей от плагина dataTables при ajax запросе
            $items = Products::getDataForDataTables($fields); //получаем данные для DataTables
            if ($items) {
                foreach ($items as $item) {
                    $item->images = view(self::tmpl . 'data-table-image', ['images' => $item->images])->render();
                    $item->actions = view(self::tmpl . 'data-table-action', ['id' => $item->id, 'shop_id' => $item->shop_id])->render();
                    $item->status = view(self::tmpl . 'data-table-status', ['status' => $item->status])->render();
                }
                $recordsTotal = Products::queryWhere(false, $fields)->count();
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
    public function addForm(Request $request){
        //если id магазина нет в массиве, значит юзер не имеет к нему доступа, кидаем ошибку 404
        $this->accessUserToShop($request->shop_id);
        $this->data['shop'] = Shops::getById($request->shop_id);
        return view(self::tmpl.'add', $this->data);
    }
    
    //добавить запись
    public function add(Request $request){
        //если id магазина нет в массиве, значит юзер не имеет к нему доступа, кидаем ошибку 404
        $this->accessUserToShop($request->shop_id);
        
        if($request->ajax()){
            $chars = json_decode($request->chars);
            $images = implode('|', json_decode($request->images));
            
            $shop = Shops::getById($request->shop_id);
            
            try{
                \DB::beginTransaction();//начало транзакции
                
                //товар
                $id = Products::add($request, $images, $shop);
                
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
                
                //массив не как объект, это важно!
                $array = [
                    'nameSite' => config('app.name'),
                    'product_id' => $id,
                    'shopId' => $shop->id,
                    'shopName' => $shop->title,
                    'shop_type_id' => $shop->shop_type_id
                ];
                
                $this->dispatch(new SendEmailVendorProducts($array));//кидаем отправку письма в очередь
                //
                
                //$this->sendMailVendorProduct($id, $shop);
                
                return response()->json(['error' => false]);
            }
            catch (\Exception $e){
                print_r($e->getMessage());
                \DB::rollback();//Отмена транзакции и изменений, вызванных её выполнением
                return response()->json(['error' => true]);
            }
            
        }
    }
    
    //форма редактирования записи
    public function editForm(Request $request){
        //если id магазина нет в массиве, значит юзер не имеет к нему доступа, кидаем ошибку 404
        $this->accessUserToShop($request->shop_id);
        
        $this->data['product'] = Products::getById($request->id, false);
        $this->data['category'] = ProductCategories::getById($this->data['product']->category_id);
        
        $shops = Shops::getAll();
        foreach($shops as $shop){
            if($shop->id == $this->data['product']->shop_id) $shop->check = true;
        }
        //$this->data['shops'] = $shops;
        
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
        $this->data['shop'] = Shops::getById($this->data['product']->shop_id);

        return view(self::tmpl.'edit', $this->data);
    }
    
    //сохранить изменения записи
    public function edit(Request $request){
        //если id магазина нет в массиве, значит юзер не имеет к нему доступа, кидаем ошибку 404
        $this->accessUserToShop($request->shop_id);
        
        if ($request->ajax()){
            $chars = json_decode($request->chars);
            $images = implode('|', json_decode($request->images));

            $shop = Shops::getById($request->shop_id);
            try{
                \DB::beginTransaction();//начало транзакции

                $update = Products::edit($request, $images);
                $this->relationCharsProduct($chars, $request->product_id);

                \DB::commit();//конец транзакции
                
                //массив не как объект, это важно!
                $array = [
                    'nameSite' => config('app.name'),
                    'product_id' => $request->product_id,
                    'shopId' => $shop->id,
                    'shopName' => $shop->title,
                    'shop_type_id' => $shop->shop_type_id
                ];
                
                $this->dispatch(new SendEmailVendorProducts($array));//кидаем отправку письма в очередь
                //
                
                //$this->sendMailVendorProduct($request->product_id, $shop);
                
                return response()->json(['error' => false]);
            }
            catch (\Exception $e){
                //print_r($e->getMessage());
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
    
    //отправка письма при редактировании/добавлени товара владельцем магазина
    /*private function sendMailVendorProduct($product_id, $shop){
        $array = [];
        $array['nameSite'] = config('app.name');
        $array['product_id'] = $product_id;
        $array['shopId'] = $shop->id;
        $array['shopName'] = $shop->title;
        $array['shop_type_id'] = $shop->shop_type_id;

        Mail::send('emails/addProductVendor', $array, function($message){
            $message->from(config('app.contacts.emailSMTP'));//от кого
            $message->to(config('app.contacts.email'));//кому отправляем
            $message->subject('Создание/Редактирование заказа');//тема письма
        });
        
    }*/
    
    public function remove(Request $request){
        if ($request->ajax()) {
            $result = Products::remove($request->id);
            return response()->json(['error' => empty($result)]);
        }
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
    
    private function getPreview($array){
        $array_shift = array_shift($array)->images;
        $preview = '';//превью товара
        if(isset($array_shift)){
            $preview = array_diff(explode('|', $array_shift), ['']);
            $preview = array_shift($preview);
        }
        return $preview;
    }
    
    private function accessUserToShop($shop_id){
        $shops = UsersShops::getShopsUser(Auth::user()->id);//магазины юзера
        //если id магазина нет в массиве, значит юзер не имеет к нему доступа, кидаем ошибку 404
        if($shops->where('shop_id', $shop_id)->first() == null){
            return abort(404);
        }
    }
    
}
