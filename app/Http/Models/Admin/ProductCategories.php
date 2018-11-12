<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class ProductCategories extends Model{
    
    public $timestamps = false;
    public $table = 'product_categories';
    
    public static function index(){
        return ProductCategories::orderBy('id', 'asc')->get();
    }
    
    public static function add($request){
        if($request->title and $request->parent_id){
            return ProductCategories::insert([
                'title' => $request->title,
                'parent_id' => $request->parent_id
            ]);
        }
    }
    
    public static function getByIdIn($array){
        return ProductCategories::whereIn('id', $array)->get();
    }
    
    public static function edit($request, $nameImage){
        $result = ProductCategories::where('id', '=', $request->id)->update([
            'title' => $request->title,
            'parent_id' => $request->parent_id,
            'image' => $nameImage
        ]);
        if($result) return true;
    }
    
    public static function remove($request){
        $result = ProductCategories::where('id', '=', $request->id)->delete();
        if($result){//если родитель бы удален, удалем и потомков
            self::removeChilds([$request->id]);
        }
        return $result;
    }
    
    public static function getById($id){
        return ProductCategories::where('id', '=', $id)->first();
    }
    
    public static function removeChilds($ids){
        $array = ProductCategories::whereIn('parent_id', $ids)->get();
        if(isset($array)){
            $ids = [];
            foreach ($array as $key => $val){
                $ids[] = $val->id;
            }
            $delete = ProductCategories::whereIn('id', $ids)->delete();
            if($delete){
                self::removeChilds($ids);
            }
        }
    }
    
    
}