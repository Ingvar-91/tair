<?php

namespace App\Http\Models\Site;

use Illuminate\Database\Eloquent\Model;

class CharsProducts extends Model{
    
    public $timestamps = false;
    public $table = 'chars_products';
    
    public static function getByProductId($product_id){
        return CharsProducts::where('chars_products.product_id', '=', $product_id)
                ->leftJoin('chars', 'chars_products.char_id', '=', 'chars.id')
                ->addSelect(
                    'chars.*',
                    'chars_products.char_id'
                )
                ->get();
    }
    
    public static function addChars($insert){
        return CharsProducts::insert($insert);
    }
    
    public static function removeInById($array){
        return CharsProducts::whereIn('id', $array)->delete();
    }

}