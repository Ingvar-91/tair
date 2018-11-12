<?php

namespace App\Http\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Reviews extends Model{
    
    public $table = 'reviews';
    //public $timestamps = false;
    
    public static function getById($id){
        return Reviews::where('id', '=', $id)->first();
    }
    
    public static function getAll(){
        return Reviews::get();
    }
    
    public static function userReviewProductExist($user_id, $product_id){
        return Reviews::where('user_id', $user_id)->where('product_id', $product_id)->count();
    }
    
    public static function userReviewShopExist($user_id, $shop_id){
        return Reviews::where('user_id', $user_id)->where('shop_id', $shop_id)->count();
    }
    
    //получить отзывы по id товаров
    public static function getAllReviewsByProductId($ids){
        return Reviews::whereIn('product_id', $ids)->get();
    }
    
    //получить отзывы товара
    public static function getAllReviewsProduct($product_id = false, $countView = false, $user_id = false){
        return Reviews::leftJoin('users', 'reviews.user_id', '=', 'users.id')
                ->addSelect(
                    'reviews.*',
                    'users.name as user_name',
                    'users.id as user_id'
                )
                ->when($product_id, function ($query) use ($product_id){
                    return $query->where('reviews.product_id', $product_id);
                })
                ->when($user_id, function ($query) use ($user_id){
                    return $query->where('user_id', $user_id);
                })
                ->when($countView === 'all', function ($query) use ($countView){
                    return $query->get();
                })
                ->when(is_numeric($countView), function ($query) use ($countView){
                    return $query->limit($countView)->get();
                })
                ->when($countView == false, function ($query) use ($countView){
                    return $query->paginate(10);
                });
    }
    
    //получить отзывы магазина
    public static function getAllReviewsShop($shop_id = false, $countView = false, $user_id = false){
        return Reviews::leftJoin('users', 'reviews.user_id', '=', 'users.id')
                ->addSelect(
                    'reviews.*',
                    'users.name as user_name',
                    'users.id as user_id'
                )
                ->when($shop_id, function ($query) use ($shop_id){
                    return $query->where('reviews.shop_id', $shop_id);
                })
                ->when($user_id, function ($query) use ($user_id){
                    return $query->where('user_id', $user_id);
                })
                ->when($countView === 'all', function ($query) use ($countView){
                    return $query->get();
                })
                ->when(is_numeric($countView), function ($query) use ($countView){
                    return $query->limit($countView)->get();
                })
                ->when($countView == false, function ($query) use ($countView){
                    return $query->paginate(10);
                });
    }
    
    //добавить отзыв для товара
    public static function addReviewProduct($request, $type){
        if(is_numeric($type)){
            return Reviews::insert([
                'type' => $type,
                'user_id' => Auth::user()->id,
                'product_id' => $request->product_id,
                'text' => $request->text,
                'rating' => $request->rating
            ]);
        }
    }
    
    //добавить отзыв в магазин
    public static function addReviewShop($request, $type){
        if(is_numeric($type)){
            return Reviews::insert([
                'type' => $type,
                'user_id' => Auth::user()->id,
                'shop_id' => $request->shop_id,
                'text' => $request->text,
                'rating' => $request->rating
            ]);
        }
    }
    
}