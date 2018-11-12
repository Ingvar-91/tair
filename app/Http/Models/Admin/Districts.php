<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Districts extends Model{
    
    //получить данные для DateTables
    public static function getDataForDataTables($fields){
        $query = Districts::orderBy($fields['nameColumn'], $fields['dirOrder'])
                ->leftJoin('cities', 'districts.city_id', '=', 'cities.id')
                        ->addSelect(
                                'districts.*',
                                'cities.title as city_name'
                                );
        
        self::queryWhere($query, $fields);
        
        if($fields['searchValue']){//если задана строка поиска
            $columns = $fields['columns'];
            $searchValue = $fields['searchValue'];
            $query->Where(function ($query) use ($columns, $searchValue) {
                $arrayWord = explode(' ', trim($searchValue));
                foreach ($arrayWord as $value) {
                    $query->orWhere('districts.title', 'like', '%'.$value.'%');
                    $query->orWhere('cities.title', 'like', '%'.$value.'%');
                }
            });
            return $query->get();
        }
        else return $query->limit($fields['limit'])->offset($fields['offset'])->get();
    }
    
    public static function queryWhere($query = false, $fields = false){
        if(!$query) $query = Districts::orderBy('id', 'desk');
        
        return $query;
    }
    
    public static function getById($id){
        return Districts::where('id', '=', $id)->first();
    }
    
    public static function add($request){
        return Districts::insertGetId([
            'title' => $request->title,
            'city_id' => $request->city_id
        ]);
    }
    
    public static function edit($request){
        $update = [
            'title' => $request->title,
            'city_id' => $request->city_id
        ];
        return Districts::where('id', $request->id)->update($update);
    }
    
    public static function remove($request){
        return Districts::where('id', '=', $request->id)->delete();
    }
}