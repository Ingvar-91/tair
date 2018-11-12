<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;

use Auth;

class HistoryProduct extends Model{
    
    public $table = 'history_product';
    public $timestamps = false;
    
    public static function index($request){
        return HistoryProduct::get();
    }
    
    public static function getById($id){
        return HistoryProduct::where('id', '=', $id)->firstOrFail();
    }
    
    public static function edit($request, $charsInsert, $id){
        $data = [
            'title' => $request->title,
            'user_id' => Auth::user()->id,
            'category_id' => $request->category_id,
            'shop_id' => $request->shop_id,
            'text' => $request->text, 
            'price' => $request->price,
            'discount' => $request->discount,
            'chars' => $charsInsert    
        ];
        
        return HistoryProduct::where('id', $id)->update([
            'data' => serialize($data)
        ]);
    }
    
}