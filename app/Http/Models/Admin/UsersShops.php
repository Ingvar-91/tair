<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Auth;

class UsersShops extends Model{
    
    public $table = 'users_shops';
    
    public static function getById($id){
        return UsersShops::where('id', '=', $id)->where('status', 2)->firstOrFail();
    }

    public static function getAll(){
        return UsersShops::where('shops.status', 2)
                ->leftJoin('shops', 'users_shops.shop_id', '=', 'shops.id')
                ->addSelect(
                        'users_shops.*',
                        'shops.title',
                        'shops.id as shop_id'
                        )
                ->get();
    }
    
    public static function getShopsUser($user_id){
        return UsersShops::where('shops.status', 2)
                ->where('users_shops.user_id', $user_id)
                ->leftJoin('shops', 'users_shops.shop_id', '=', 'shops.id')
                ->addSelect(
                        'users_shops.*',
                        'shops.title',
                        'shops.id as shop_id'
                        )
                ->get();
    }
    
    public static function addShop($user_id, $shop_id){
        return UsersShops::insert([
            'user_id' => $user_id,
            'shop_id' => $shop_id
        ]);
    }
    
    public static function addShops($users_shops, $user_id){
        if(count($users_shops) and $user_id){
            foreach($users_shops as $shop_id){
                $insert[] = [
                    'user_id' => $user_id,
                    'shop_id' => $shop_id,
                ];
            }
            return UsersShops::insert($insert);
        }
        return false;
    }
    
    public static function getAllRelation($user_id){
        return UsersShops::where('user_id', '=', $user_id)->get();
    }
    
    public static function removeInId($array){
        return UsersShops::whereIn('id', $array)->delete();
    }
    
}