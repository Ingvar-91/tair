<?php

namespace App\Http\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Slider extends Model{
    
    public $table = 'slider';
    public $timestamps = false;
    
    public static function getById($id){
        return Slider::where('id', '=', $id)->first();
    }
    
    public static function getAll(){
        return Slider::get();
    }
    
}