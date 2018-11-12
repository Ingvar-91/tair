<?php

namespace App\Http\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Brands extends Model{
    
    public $table = 'brands';
    public $timestamps = false;
    
    public static function getById($id){
        return Brands::where('id', '=', $id)->first();
    }
    
    public static function getAll(){
        return Brands::get();
    }
    
}