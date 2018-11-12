<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Reviews extends Model{
    
    public $timestamps = false;
    public $table = 'reviews';
    
    //получить данные для DateTables
    public static function getDataForDataTables($fields){
        $query = Reviews::orderBy($fields['nameColumn'], $fields['dirOrder'])
                ->leftJoin('users', 'reviews.user_id', '=', 'users.id')
                ->addSelect(
                    'reviews.*',
                    'users.email as user_email',
                    'users.name as user_name'
                );
        
        self::queryWhere($query, $fields);
        
        if($fields['searchValue']){//если задана строка поиска
            $columns = $fields['columns'];
            $searchValue = $fields['searchValue'];
            $query->Where(function ($query) use ($columns, $searchValue) {
                $arrayWord = explode(' ', trim($searchValue));
                foreach ($arrayWord as $value) {
                    $query->orWhere('reviews.text', 'like', '%'.$value.'%');
                    $query->orWhere('users.email', 'like', '%'.$value.'%');
                    $query->orWhere('users.name', 'like', '%'.$value.'%');
                }
            });
            return $query->get();
        }
        else return $query->limit($fields['limit'])->offset($fields['offset'])->get();
    }
    
    public static function queryWhere($query = false, $fields = false){
        if(!$query) $query = Reviews::orderBy('id', 'desk');
        
        return $query;
    }
    
    public static function getById($id){
        return Reviews::where('id', '=', $id)->first();
    }
    
    public static function getAll(){
        return Reviews::get();
    }
    
    /*public static function add($request){
        return Reviews::insert([
            'title' => $request->title
        ]);
    }*/
    
    /*public static function edit($request){
        $update = [
            'title' => $request->title
        ];
        return ShopCategories::where('id', $request->id)->update($update);
    }*/
    
    public static function remove($request){
        return Reviews::where('id', '=', $request->id)->delete();
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
}