<?php

namespace App\Http\Models\Site;

use Illuminate\Database\Eloquent\Model;
use App\Http\Models\Site\Chars;
use Auth;
use DB;

class Chars extends Model{
    
    public $timestamps = false;
    public $table = 'chars';
    
    protected $fillable = array('title', 'category_id');
    
    public static function index($request){
        return Chars::where('category_id', '=', $request->category_id)->orderBy('num_order')->orWhere('common', '=', 1)->get();
    }
    
    public static function getByCategoryIdIn($array){
        return Chars::whereIn('category_id', $array)->orderBy('num_order')->get();
    }
    
    public static function getParents($chars){
        return Chars::whereIn('id', $chars->pluck('parent_id'))->orderBy('num_order')->get();
    }
    
    public static function getByInId($array){
        return Chars::whereIn('id', $array)->orderBy('num_order')->get();
    }
    

}