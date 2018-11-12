<?php

namespace App\Http\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Auth;

class ShopCategories extends Model{
    
    public $timestamps = false;
    public $table = 'shop_categories';
    
    public static function getById($id){
        return ShopCategories::where('id', '=', $id)->first();
    }
    
    public static function getAll(){
        return ShopCategories::get();
    }
    
    public static function add($request){
        return ShopCategories::insert([
            'title' => $request->title
        ]);
    }
    
    public static function edit($request){
        $update = [
            'title' => $request->title
        ];
        return ShopCategories::where('id', $request->id)->update($update);
    }
    
    public static function remove($request){
        return ShopCategories::where('id', '=', $request->id)->delete();
    }
}