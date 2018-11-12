<?php

namespace App\Http\Models\Site;

use Illuminate\Database\Eloquent\Model;

use App\Helpers\Helper;
use Auth;

class Order_product extends Model{
    
    public $table = 'order_product';
    
    public static function add($products, $cookieCart, $order_id, $shop_id){
        if($products){
            $insert = [];
            $i = 0;
            
            foreach ($products as $key => $val) {
                $price = 0;
                if(Helper::isDiscount($val->start_discount, $val->end_discount, $val->discount)){
                    $price = $val->discount;
                }   
                else{
                    if($val->price){
                        $price = ($val->price - ($val->price / '10%'));
                    }
                }
                $insert[$i] = [
                    'product_id' => $val->id,
                    'order_id' => $order_id,
                    'shop_id' => $shop_id,
                    'count' => $cookieCart[$val->id]->count,  
                    'price' => $price
                ];
                
                if(isset($cookieCart[$val->id]->chars)){
                    $insert[$i]['chars'] = serialize($cookieCart[$val->id]->chars);
                }
                
                if(Auth::check()){
                    $insert[$i]['user_id'] = Auth::user()->id;
                }
                
                $i++;
            }
            return Order_product::insert($insert);
        }
    }
    
    /*public static function userOrderProductExist($user_id, $product_id){
        return Order_product::where('order_product.user_id', $user_id)
                ->where('order_product.product_id', $product_id)
                ->leftJoin('orders', 'order_product.order_id', '=', 'orders.id')
                ->addSelect(
                    'order_product.*',
                    'orders.status as order_status'
                )
                ->count();
    }*/
    
    /*public static function userOrderShopExist($user_id, $shop_id){
        return Order_product::where('order_product.user_id', $user_id)
                ->where('order_product.shop_id', $shop_id)
                ->leftJoin('orders', 'order_product.order_id', '=', 'orders.id')
                ->addSelect(
                    'order_product.*',
                    'orders.status as order_status'
                )
                ->count();
    }*/
    
}