<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model{
    
    public $table = 'posts';
    public $timestamps = false;
    
    public static function getById($id) {
        return Posts::where('id', '=', $id)->first();
    }
    
    public static function getAll() {
        return Posts::get();
    }
    
    public static function getByType($type, $page) {
        return Posts::where('type', $type)->where('page', $page)->first();
    }
    
}