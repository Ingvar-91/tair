<?php

namespace App\Http\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Districts extends Model{
    
    public static function getByCityId($id){
        return Districts::where('city_id', $id)->get();
    }
    
    public static function getById($id){
        return Districts::where('id', '=', $id)->firstOrFail();
    }
    
}