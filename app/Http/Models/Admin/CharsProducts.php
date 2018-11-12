<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class CharsProducts extends Model{
    
    public $timestamps = false;
    public $table = 'chars_products';
    
    public static function addChars($insert){
        return CharsProducts::insert($insert);
        /*if(isset($chars)){
            $insert = [];
            $i = 0;
            foreach ($chars as $array) {
                foreach ($array as $id) {
                    $insert[$i]['char_id'] = $id;
                    $insert[$i]['product_id'] = $product_id;
                    $i++;
                }
            }
            return CharsProducts::insert($insert);
        }*/
    }
    
    public static function getByProductId($product_id){
        return CharsProducts::where('product_id', '=', $product_id)->get();
    }
    
    public static function removeInById($array){
        return CharsProducts::whereIn('id', $array)->delete();
    }
    
}