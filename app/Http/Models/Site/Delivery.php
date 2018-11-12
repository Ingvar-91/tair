<?php

namespace App\Http\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class Delivery extends Model{
    
    public $timestamps = false;
    public $table = 'delivery';
    
    public static function getById($id){
        return Delivery::where('id', '=', $id)->first();
    }
    
    public static function remove($request){
        return Delivery::where('id', '=', $request->id)->delete();
    }
    
    public static function getDelivery($district_id, $shop_id){
        return Delivery::where('shop_id', '=', $shop_id)->where('district_id', '=', $district_id)->first();
    }

    public static function getShipping($district_id){
        return Delivery::where('district_id', '=', $district_id)->get();
    }
}