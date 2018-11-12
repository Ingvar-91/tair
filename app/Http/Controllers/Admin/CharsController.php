<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;

use App\Http\Models\Admin\Chars;
use App\Http\Models\Admin\CharsProducts;
use App\Http\Models\Admin\ProductCategories;

use Redirect;

class CharsController extends Controller {
    
    const tmpl = 'admin/chars/';
    
    private $categoriesId;
    
    public function __construct(){
        parent::__construct();
        
        $this->categoriesId = collect();
    }
    
    public function index(Request $request){
        //получить все id родителей, вплоть до самого первого
        $this->getCategoriesId($request->category_id);
        
        if($request->ajax()){
            $chars = collect([Chars::index($request), Chars::getByCategoryIdIn($this->categoriesId)]);
            $chars = $chars->collapse();
            
            if($request->product_id){
                $charsProducts = CharsProducts::getByProductId($request->product_id);
                foreach($chars as $char){
                    if($char->parent_id == 0) continue;
                    $check = $charsProducts->where('char_id', $char->id)->count();
                    if($check){
                        $char->check = true;
                    }
                } 
            }

            $chars = $this->buildTree($chars);
            return response()->json(['chars' => $chars]);
        }
        
        $this->data['category'] = ProductCategories::getById($request->category_id);
        $chars = collect([Chars::index($request), Chars::getByCategoryIdIn($this->categoriesId)]);
        $chars = $chars->collapse();
        $this->data['chars'] = $this->buildTree($chars);
        return view(self::tmpl.'index', $this->data);
    }
    
    public function add(Request $request){
        if($request->ajax()){
            return response()->json(['error' => empty(Chars::add($request))]);
        }
        else{
            $result = Chars::addParent($request);
            if($result) return Redirect::back()->with('message-success', 'Данные успешно добавлены.');
            else return Redirect::back()->with('message-error', 'Произошла ошибка при добавлении данных.');
        }
    }
    
    public function remove(Request $request){
        if($request->ajax()){
            return response()->json(['error' => empty(Chars::remove($request))]);
        } 
    }
    
    public function sort(Request $request){
        if($request->ajax()){
            //
            $chars = Chars::getByParentId($request->parent_id);
            
            $tagsCollect = collect($request->tags);// новая коллекция с тегами
            $updateChars = collect();// коллекция для обновляния
            foreach ($chars as $key => $char) {
                $search = $tagsCollect->search($char->title);
                if($char->num_order != $search + 1){
                    $char->num_order = $search + 1;
                    $updateChars->push($char);
                }
            }
            
            try{
                \DB::beginTransaction();//нало транзакции
                
                foreach ($updateChars as $updateChar) {
                    Chars::editSort($updateChar->title, $request->parent_id, $updateChar->num_order);
                }
                        
                \DB::commit();//конец транзакции
                return response()->json(['error' => false]);
            }
            catch (\Exception $e){
                //print_r($e->getMessage());
                \DB::rollback();//Отмена транзакции и изменений, вызванных её выполнением
                return response()->json(['error' => true]);
            }

        } 
    }
    
    public function edit(Request $request){
        if($request->ajax()){
            return response()->json(['error' => empty(Chars::edit($request))]);
        }
    }
    
    public function editParent(Request $request){
        if($request->ajax()){
            return response()->json(['error' => empty(Chars::editParent($request))]);
        }
    }
    
    public function removeParent(Request $request){
        if($request->ajax()){
            try{
                \DB::beginTransaction();//нало транзакции
                
                Chars::removeByParentId($request->id);
                Chars::removeParent($request->id);
                        
                \DB::commit();//конец транзакции
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

}