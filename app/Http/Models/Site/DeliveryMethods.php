<?php

namespace App\Http\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Auth;

class DeliveryMethods extends Model{
    
    public $timestamps = false;
    public $table = 'delivery_methods';
    
    public static function getById($id){
        return DeliveryMethods::where('id', '=', $id)->firstOrFail();
    }
    
    public static function getAll(){
        return DeliveryMethods::get();
    }
    
}