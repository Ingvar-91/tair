<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Order_product extends Model{
    
    public $table = 'order_product';
    
    public static function index($request){
        return Order_product::orderBy('order_product.id', 'ask')
                ->where('order_id', $request->id)
                ->leftJoin('products', 'order_product.product_id', '=', 'products.id')
                ->addSelect(
                        'order_product.*',
                        'products.category_id',
                        'products.title as product_title'
                )
                ->get();
    }
    
}