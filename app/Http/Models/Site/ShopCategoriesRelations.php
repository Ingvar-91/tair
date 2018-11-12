<?php

namespace App\Http\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Auth;

class ShopCategoriesRelations extends Model{
    
    public $timestamps = false;
    public $table = 'shop_categories_relations';
    
    
    public static function getById($id){
        return ShopCategoriesRelations::where('id', '=', $id)->first();
    }
    
    public static function getAll(){
        return ShopCategoriesRelations::get();
    }
    
    public static function add($shop_categories_relations, $shop_id){
        if(count($shop_categories_relations) and $shop_id){
            foreach($shop_categories_relations as $val){
                $insert[] = [
                    'shop_id' => $shop_id,
                    'shop_category_id' => $val,
                ];
            }
            return ShopCategoriesRelations::insert($insert);
        }
    }
    
    public static function edit($request){
        $update = [
            'shop_id' => $request->title,
            'shop_category_id' => $request->shop_category_id,
        ];
        return ShopCategoriesRelations::where('id', $request->id)->update($update);
    }
    
    public static function remove($request){
        return ShopCategoriesRelations::where('id', '=', $request->id)->delete();
    }
    
    public static function getAllRelation($request){
        return ShopCategoriesRelations::where('shop_id', '=', $request->id)->get();
    }
    
    public static function removeInId($array){
        return ShopCategoriesRelations::whereIn('id', $array)->delete();
    }
    
}