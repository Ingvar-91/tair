<?php

namespace App\Http\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Cities extends Model{
    
    
    public static function getById($id){
        return Cities::where('id', '=', $id)->firstOrFail();
    }
    
    public static function getAll(){
        return Cities::get();
    }
    
}