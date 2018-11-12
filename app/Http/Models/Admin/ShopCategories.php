<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Auth;

class ShopCategories extends Model{
    
    public $timestamps = false;
    public $table = 'shop_categories';
    
    //получить данные для DateTables
    public static function getDataForDataTables($fields){
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
    }
    
    public static function getById($id){
        return ShopCategories::where('id', '=', $id)->first();
    }
    
    public static function getAll(){
        return ShopCategories::get();
    }
    
    public static function add($request){
        return ShopCategories::insert([
            'title' => $request->title
        ]);
    }
    
    public static function edit($request){
        $update = [
            'title' => $request->title
        ];
        return ShopCategories::where('id', $request->id)->update($update);
    }
    
    public static function remove($request){
        return ShopCategories::where('id', '=', $request->id)->delete();
    }
}