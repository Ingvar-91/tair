<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class DistrictsMinPrice extends Model{
    
    public $table = 'districts_min_price';
    public $timestamps = false;
    
    public static function getById($id){
        return DistrictsMinPrice::where('id', '=', $id)->first();
    }
    
    public static function add($request, $district_id){
        foreach($request->min_price as $id => $price){
            $insert[] = [
                'district_id' => $district_id,
                'shop_id' => $id,
                'price' => $price
            ];
        }
        return DistrictsMinPrice::insert($insert);
    }
    
    public static function edit($request){
        $min_price = $request->min_price;
        $district_id = $request->id;
        DB::transaction(function () use ($min_price, $district_id){
            foreach($min_price as $shop_id => $price){
                //достаем запись
                $record = DistrictsMinPrice::where('district_id', $district_id)->where('shop_id', $shop_id)->first();
                
                //если такая есть, то обновляем, если нет, добавляем
                if($record){
                    DistrictsMinPrice::where('id', $record->id)->update(['price' => $price]);
                }
                else{
                    DistrictsMinPrice::insert([
                        'district_id' => $district_id,
                        'shop_id' => $shop_id,
                        'price' => $price
                    ]);
                }
            }
        });
    }
    
    public static function remove($request){
        return DistrictsMinPrice::where('id', '=', $request->id)->delete();
    }
    
    public static function getMinPrice($district_id){
        return DistrictsMinPrice::where('district_id', '=', $district_id)->get();
    }
    
    
}