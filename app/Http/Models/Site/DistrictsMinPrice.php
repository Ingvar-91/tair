<?php

namespace App\Http\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class DistrictsMinPrice extends Model{
    
    public $table = 'districts_min_price';
    public $timestamps = false;
    
    public static function getById($id){
        return DistrictsMinPrice::where('id', '=', $id)->first();
    }
    
    public static function getDistricts($shop_id, $city_id = false){
        return DistrictsMinPrice::where('districts_min_price.shop_id', '=', $shop_id)
                ->where('districts_min_price.price', '!=', null)
                ->when($city_id, function ($query) use ($city_id) {
                    return $query->where('districts.city_id', '=', $city_id);
                })
                ->leftJoin('districts', 'districts_min_price.district_id', '=', 'districts.id')
                ->addSelect(
                    'districts_min_price.*',
                    'districts.title as districts_title',
                    'districts.city_id'
                )
                ->get();
    }
    
    public static function getMinPriceForDistrict($district_id, $shop_id){
        return DistrictsMinPrice::where('district_id', '=', $district_id)->where('shop_id', '=', $shop_id)->firstOrFail();
    }
    
    
}