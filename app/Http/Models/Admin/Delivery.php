<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class Delivery extends Model{
    
    public $timestamps = false;
    public $table = 'delivery';
    
    //получить данные для DateTables
    public static function getDataForDataTables($fields){
        $query = Delivery::orderBy($fields['nameColumn'], $fields['dirOrder']);
        
        if($fields['searchValue']){//если задана строка поиска
            $columns = $fields['columns'];
            $searchValue = $fields['searchValue'];
            $query->Where(function ($query) use ($columns, $searchValue) {
                $arrayWord = explode(' ', trim($searchValue));
                foreach ($arrayWord as $value) {
                    $query->orWhere('title', 'like', '%'.$value.'%');
                    $query->orWhere('text', 'like', '%'.$value.'%');
                }
            });
            return $query->get();
        }
        else return $query->limit($fields['limit'])->offset($fields['offset'])->get();
    }
    
    public static function queryWhere($query = false, $fields = false){
        if(!$query) $query = Delivery::orderBy('id', 'desk');
        
        return $query;
    }
    
    public static function getById($id){
        return Delivery::where('id', '=', $id)->first();
    }
    
    public static function add($request, $district_id){
        foreach($request->rate_shipping as $id => $price){
            $insert[] = [
                'district_id' => $district_id,
                'shop_id' => $id,
                'data' => serialize([
                    'free_shipping' => ['price' => $request->free_shipping[$id]],
                    'rate_shipping' => ['price' => $price]
                ])
            ];
        }
        return Delivery::insert($insert);
    }
    
    public static function edit($request){
        $rate_shipping = $request->rate_shipping;
        $free_shipping = $request->free_shipping;
        $district_id = $request->id;
        DB::transaction(function () use ($rate_shipping, $free_shipping, $district_id){
            foreach($rate_shipping as $shop_id => $price){
                //достаем запись
                $record = Delivery::where('district_id', $district_id)->where('shop_id', $shop_id)->first();
                
                //если такая есть, то обновляем, если нет, добавляем
                if($record){
                    Delivery::where('id', $record->id)->update([
                        'data' => serialize([
                            'free_shipping' => ['price' => $free_shipping[$shop_id]],
                            'rate_shipping' => ['price' => $price]
                        ])
                    ]);
                }
                else{
                    Delivery::insert([
                        'district_id' => $district_id,
                        'shop_id' => $shop_id,
                        'data' => serialize([
                            'free_shipping' => ['price' => $free_shipping[$shop_id]],
                            'rate_shipping' => ['price' => $price]
                        ])
                    ]);
                }
            }
        });
    }
    
    public static function remove($request){
        return Delivery::where('id', '=', $request->id)->delete();
    }

    public static function getShipping($district_id){
        return Delivery::where('district_id', '=', $district_id)->get();
    }
}