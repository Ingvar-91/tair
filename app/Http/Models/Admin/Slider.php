<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Slider extends Model{
    
    public $table = 'slider';
    public $timestamps = false;
    
    //получить данные для DateTables
    /*public static function getDataForDataTables($fields){
        $query = Slider::orderBy($fields['nameColumn'], $fields['dirOrder']);
        
        if($fields['searchValue']){//если задана строка поиска
            $columns = $fields['columns'];
            $searchValue = $fields['searchValue'];
            $query->Where(function ($query) use ($columns, $searchValue) {
                $arrayWord = explode(' ', trim($searchValue));
                foreach ($arrayWord as $value) {
                    $query->orWhere('title', 'like', '%'.$value.'%');
                    $query->orWhere('note', 'like', '%'.$value.'%');
                    $query->orWhere('info', 'like', '%'.$value.'%');
                    $query->orWhere('desc', 'like', '%'.$value.'%');
                }
            });
            return $query->get();
        }
        else return $query->limit($fields['limit'])->offset($fields['offset'])->get();
    }
    
    public static function queryWhere($query = false, $fields = false){
        if(!$query) $query = Slider::orderBy('id', 'desk');
        
        return $query;
    }
    
    public static function getById($id){
        return Slider::where('id', '=', $id)->firstOrFail();
    }
    
    public static function add($request, $images = ''){
        return Slider::insert([
            'images' => $images
        ]);
    }
    
    public static function edit($request, $images = ''){
        $updete['images'] = $images;
        return Slider::where('id', $request->id)->update($updete);
    }
    
    public static function remove($request){
        return Slider::where('id', '=', $request->id)->delete();
    }*/
    
    public static function edit($request){
        return Slider::where('id', $request->id)->update([
            'images' => implode('|', $request->images)
        ]);
    }
    
    public static function getAll(){
        return Slider::get();
    }
    
}