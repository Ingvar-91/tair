<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;
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
    
    public static function addParent($request){
        return Chars::insert([
            'title' => trim($request->title),
            'category_id' => $request->category_id,
            'parent_id' => $request->parent_id,
            'common' => $request->common,
            'selected_order' => $request->selected_order
        ]);
    }
    
    public static function add($request){
        if(!trim($request->title)) return false;
        
        //проверяем начличие такой записи
        $exist = Chars::where('title', trim($request->title))
                ->where('category_id', $request->category_id)
                ->where('parent_id', $request->parent_id)
                ->get();
        
        if($exist->count()) return false;
        
        //если нет, тогда добавляем
        return Chars::insert([
            'title' => trim($request->title),
            'category_id' => $request->category_id,
            'parent_id' => $request->parent_id,
            'common' => $request->common,
            'num_order' => Chars::getByParentId($request->parent_id, true) + 1,
            'selected_order' => $request->selected_order
        ]);
    }
    
    public static function edit($request){
        return Chars::where('title', $request->oldValue)
                //->where('category_id', $request->category_id)
                ->where('parent_id', $request->parent_id)
                ->update([
                    'title' => $request->newValue
                ]);
    }
    
    public static function editSort($title, $parent_id, $num_order){
        return Chars::where('title', $title)
                ->where('parent_id', $parent_id)
                ->update([
                    'num_order' => $num_order
                ]);
    }
    
    public static function editParent($request){
        return Chars::where('id', $request->id)
                ->update([
                    'title' => $request->title
                ]);
    }
    
    public static function remove($request){
        return Chars::where('title', $request->title)
                ->where('parent_id', $request->parent_id)
                ->delete();
    }
    
    public static function getByInId($array){
        return Chars::whereIn('id', $array)->orderBy('num_order')->get();
    }
    
    public static function getByParentId($parent_id, $getCount = false){
        $query = Chars::where('parent_id', $parent_id)->orderBy('num_order');   
                
        if($getCount == true){
            return $query->count();
        }
        else{
            return $query->get();
        }
    }
    
    public static function getParents($chars){
        return Chars::whereIn('id', $chars->pluck('parent_id'))->orderBy('num_order')->get();
    }
    
    public static function removeParent($id){
        return Chars::where('id', $id)->delete();
    }
    
    public static function removeByParentId($id){
        return Chars::where('parent_id', $id)->delete();
    }
    
    public static function getByShopType($shop_type_id){
        return Chars::where('parent_id', '=', 0)->orderBy('num_order')->where('shop_type_id', '=', $shop_type_id)->get();
    }

}