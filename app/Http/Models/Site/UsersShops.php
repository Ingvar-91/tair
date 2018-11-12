<?php

namespace App\Http\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Auth;

class UsersShops extends Model{
    
    public $table = 'users_shops';
    
    public static function getById($id){
        return UsersShops::where('id', '=', $id)->where('status', 2)->firstOrFail();
    }

    public static function getAll(){
        return UsersShops::where('status', 2)->get();
    }
    
    //получить магазины пользователя
    public static function getShopsUser($user_id){
        return UsersShops::where('status', 2)
                ->where('user_id', $user_id)
                ->leftJoin('shops', 'users_shops.shop_id', '=', 'shops.id')
                ->addSelect(
                        'users_shops.*',
                        'shops.title',
                        'shops.id as shop_id',
                        'shops.short_description',
                        'shops.images as shop_images'
                        )
                ->get();
    }
    
    public static function addShop($user_id, $shop_id){
        return UsersShops::insert([
            'user_id' => $user_id,
            'shop_id' => $shop_id
        ]);
    }
    
}