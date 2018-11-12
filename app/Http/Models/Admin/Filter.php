<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Filter extends Model{
    
    public $timestamps = false;
    public $table = 'filter';
    
    //получить данные для DateTables
    /*public static function getDataForDataTables($fields){
        $query = ShopCategories::orderBy($fields['nameColumn'], $fields['dirOrder']);
        
        self::queryWhere($query, $fields);
        
        if($fields['searchValue']){//если задана строка поиска
            $columns = $fields['columns'];
            $searchValue = $fields['searchValue'];
            $query->Where(function ($query) use ($columns, $searchValue) {
                $arrayWord = explode(' ', trim($searchValue));
                foreach ($arrayWord as $value) {
                    $query->orWhere('title', 'like', '%'.$value.'%');
                }
            });
            return $query->get();
        }
        else return $query->limit($fields['limit'])->offset($fields['offset'])->get();
    }
    
    public static function queryWhere($query = false, $fields = false){
        if(!$query) $query = ShopCategories::orderBy('id', 'desk');
        
        return $query;
    }*/
    
    public static function getById($id){
        return Filter::where('id', '=', $id)->first();
    }
    
    public static function getAll(){
        return Filter::get();
    }
    
    public static function getByShopType($shop_type_id){
        return Filter::where('shop_type_id', '=', $shop_type_id)->get();
    }
    
    public static function addFilter($array, $shop_type_id){
        if(count($array) and $shop_type_id){
            foreach($array as $val){
                $insert[] = [
                    'characteristics_name_id' => $val,
                    'shop_type_id' => $shop_type_id
                ];
            }
            return Filter::insert($insert);
        }
        return false;
    }
    
    public static function removeInId($array){
        return Filter::whereIn('id', $array)->delete();
    }
    
    public static function add($request){
        return Filter::insert([
            'title' => $request->title
        ]);
    }
    
    public static function edit($request){
        $update = [
            'title' => $request->title
        ];
        return Filter::where('id', $request->id)->update($update);
    }
    
    public static function remove($request){
        return Filter::where('id', '=', $request->id)->delete();
    }
}