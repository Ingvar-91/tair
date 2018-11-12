<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Auth;

class ShopsType extends Model{
    
    public $timestamps = false;
    public $table = 'shops_type';
    
    //получить данные для DateTables
    public static function getDataForDataTables($fields){
        $query = ShopsType::orderBy($fields['nameColumn'], $fields['dirOrder']);
        
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
        if(!$query) $query = ShopsType::orderBy('id', 'desk');
        
        return $query;
    }
    
    public static function getById($id){
        return ShopsType::where('id', '=', $id)->firstOrFail();
    }
    
    public static function getAll(){
        return ShopsType::get();
    }
    
    public static function add($request){
        return ShopsType::insert([
            'title' => $request->title
        ]);
    }
    
    public static function edit($request){
        $update = [
            'title' => $request->title
        ];
        return ShopsType::where('id', $request->id)->update($update);
    }
    
    public static function remove($request){
        return ShopsType::where('id', '=', $request->id)->delete();
    }
}