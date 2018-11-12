<?php

namespace App\Http\Models\Site;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model{
    
    public $table = 'posts';
    public $timestamps = false;
    
    public static function getById($id){
        return Posts::where('id', '=', $id)->first();
    }
    
    public static function getAll(){
        return Posts::get();
    }
    
}