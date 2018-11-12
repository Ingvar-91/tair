<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Auth;

class DeliveryMethods extends Model{
    
    public $timestamps = false;
    public $table = 'delivery_methods';
    
    public static function getById($id){
        return DeliveryMethods::where('id', '=', $id)->firstOrFail();
    }
    
    public static function getAll(){
        return DeliveryMethods::get();
    }
    
    public static function add($request){
        return DeliveryMethods::insert([
            'title' => $request->title
        ]);
    }
    
    public static function edit($request){
        $update = [
            'title' => $request->title
        ];
        return DeliveryMethods::where('id', $request->id)->update($update);
    }
    
    public static function remove($request){
        return DeliveryMethods::where('id', '=', $request->id)->delete();
    }
}