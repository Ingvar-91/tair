<?php

namespace App\Http\Models\Site;

use Illuminate\Database\Eloquent\Model;

use App\Http\Models\Site\Order_product;

use Auth;

class Orders extends Model{
    
    public $table = 'orders';
    
    public static function add($request){
        $insert = [
            'city_id' => $request->city_id,
            'district_id' => $request->district_id,
            'street' => $request->street,
            'phone' => $request->phone,
            'delivery_id' => $request->delivery_id,
            'delivery_price' => $request->delivery_price,
            'fio' => $request->fio,
            'payment_id' => $request->payment_id,
            'deal' => $request->deal
        ];
        
        if(Auth::check()) $insert['user_id'] = Auth::user()->id;

        if(isset($request->email)) $insert['email'] = $request->email;
        if(isset($request->apartment)) $insert['apartment'] = $request->apartment;
        if(isset($request->home)) $insert['home'] = $request->home;
        if(isset($request->floor)) $insert['floor'] = $request->floor;
        if(isset($request->intercom)) $insert['intercom'] = $request->intercom;
        if(isset($request->building)) $insert['building'] = $request->building;
        if(isset($request->entrance)) $insert['entrance'] = $request->entrance;
        if(isset($request->note)) $insert['note'] = $request->note;
        
        return Orders::insertGetId($insert);
    }
    
    public static function getOrderById($request){
        $order = Orders::where('orders.id', $request->id)
                ->leftJoin('delivery_methods', 'orders.delivery_id', '=', 'delivery_methods.id')
                ->addSelect(
                    'orders.*',
                    'delivery_methods.title as delivery_title'
                )
                ->leftJoin('payment_methods', 'orders.payment_id', '=', 'payment_methods.id')
                ->addSelect(
                    'orders.*',
                    'payment_methods.title as payment_title'
                )
                ->firstOrFail();
        
        $order_product = Order_product::where('order_product.order_id', $order->id)
                ->leftJoin('products', 'order_product.product_id', '=', 'products.id')
                ->addSelect(
                        'order_product.*',
                        'products.category_id',
                        'products.title as product_title',
                        'products.images as product_images'
                )
                ->get();
        
        $products = [];
        $total = 0;
        foreach ($order_product as $id => $val) {
            $products[] = $val;
            $total = $total + ($val->price * $val->count);
        }
        $order->products = $products;
        $order->total = $total;

        return $order;
    }
    
    public static function getOrdersByUser($user_id, $statusArray){
        $orders = Orders::orderBy('id', 'desc')
                ->where('user_id', $user_id)
                ->when($statusArray, function ($query) use ($statusArray) {
                    return $query->whereIn('status', $statusArray);
                })
                ->paginate(6);
        
        $order_product = Order_product::whereIn('order_product.order_id', $orders->pluck('id'))
                ->leftJoin('products', 'order_product.product_id', '=', 'products.id')
                ->addSelect(
                        'order_product.*',
                        'products.category_id',
                        'products.title as product_title'
                )
                ->get();
        
        $newArr = [];
        foreach ($order_product as $id => $val) {
            $newArr[$val->order_id]->products[] = $val;
            if(!isset($newArr[$val->order_id]->total)){
                $newArr[$val->order_id]->total = 0;
            }
            $newArr[$val->order_id]->total = $newArr[$val->order_id]->total + ($val->price * $val->count);
        }
        
        foreach ($orders as $order){
            if(isset($newArr[$order->id]->products)){
                $order->products = $newArr[$order->id]->products;
                $order->total = $newArr[$order->id]->total;
            }
        }
        return $orders;
    }
    
}