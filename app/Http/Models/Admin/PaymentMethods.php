<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Auth;

class PaymentMethods extends Model{
    
    public $timestamps = false;
    public $table = 'payment_methods';
    
    public static function getById($id){
        return PaymentMethods::where('id', '=', $id)->firstOrFail();
    }
    
    public static function getAll(){
        return PaymentMethods::get();
    }
    
    public static function add($request){
        return PaymentMethods::insert([
            'title' => $request->title
        ]);
    }
    
    public static function edit($request){
        $update = [
            'title' => $request->title
        ];
        return PaymentMethods::where('id', $request->id)->update($update);
    }
    
    public static function remove($request){
        return PaymentMethods::where('id', '=', $request->id)->delete();
    }
}