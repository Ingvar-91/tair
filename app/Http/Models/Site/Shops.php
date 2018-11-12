<?php

namespace App\Http\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class Shops extends Model {
    
    //получить топ магазинов
    public static function getTopShops($limit = false){
        return Shops::where('status', 2)
                ->where('to_top', 1)
                ->where('shop_type_id', 1)
                ->when($limit, function ($query, $limit) {
                    return $query->limit($limit);
                })
                ->get();
    }
    
    //получить топ развелекательных мест
    public static function getTopEntertainmentPlaces() {
        return Shops::where('status', 2)
                ->where('to_top', 1)
                ->whereIn('shop_type_id', [2, 4, 5])
                ->get();
    }
    
    //получить все равлекательные места
    public static function getAllEntertainmentPlaces($limit = false) {
        return Shops::where('status', 2)
                ->whereIn('shop_type_id', [2, 4, 5])
                ->when($limit, function ($query, $limit) {
                    return $query->limit($limit);
                })
                ->get();
    }
    
    public static function getById($id) {
        return Shops::where('id', '=', $id)->where('status', 2)->firstOrFail();
    }
    
    public static function getByPlaceholder($placeholder) {
        return Shops::where('placeholder', '=', $placeholder)->where('status', 2)->firstOrFail();
    }

    public static function getAll() {
        return Shops::where('status', 2)->get();
    }
    
    public static function getShopsAndCountProduct() {
        return Products::select(
                    'shops.id',
                    'shops.title',
                    'shops.placeholder',
                    'shops.main_phone', 
                    'shops.preview_frontpage',
                    'shops.shop_type_id',
                    DB::raw('count(*) as `count`')
                )
                ->join('shops', 'products.shop_id', '=', 'shops.id')
                ->groupBy('products.shop_id')
                ->where('products.status', 2)
                ->where('products.del', 1)
                ->where('shops.status', 2)
                ->where('products.date_remove', '>', date('Y-m-d H:i:s'))
                ->get();   
    }
    
    public static function getShopsForContacts() {
        return Shops::select(
                    'shops.id',
                    'shops.title',
                    'shops.main_phone',
                    'shops.logo'
                )
                ->where('shops.status', 2)
                ->get();   
    }
    
    public static function add($request, $images = '') {
        return Shops::insertGetId([
            'title' => $request->title,
            'vacancy' => $request->vacancy,
            'contacts' => $request->contacts,
            'about' => $request->about,
            'images' => $images
        ]);
    }
    
    public static function edit($request, $images = '') {
        $update = [
            //'title' => $request->title,
            'vacancy' => $request->vacancy,
            'contacts' => $request->contacts,
            'about' => $request->about,
            //'status' => 1,
        ];
        if($images) $updete['images'] = $images;
        
        return Shops::where('id', $request->id)->update($update);
    }

}