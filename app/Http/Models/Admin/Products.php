<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Products extends Model{
    
    //получить данные для DateTables
    public static function getDataForDataTables($fields, $shop_type){
        $shop_id = $fields['shop_id'];
        $category_id = $fields['category_id'];
        
        $query = Products::orderBy($fields['nameColumn'], $fields['dirOrder'])
                ->leftJoin('users', 'products.user_id', '=', 'users.id')
                ->addSelect(
                    'products.*',
                    'users.email',
                    'users.name'
                )
                ->when($shop_id, function ($query) use ($shop_id) {
                    return $query->where('products.shop_id', $shop_id);
                })
                ->when($category_id, function ($query) use ($category_id) {
                    return $query->where('products.category_id', $category_id);
                })
                ->leftJoin('shops', 'products.shop_id', '=', 'shops.id')
                ->addSelect(
                    'shops.title as shops_title'
                );
        
        self::queryWhere($query, $fields, $shop_type);
        
        if($fields['searchValue']){//если задана строка поиска
            $columns = $fields['columns'];
            $searchValue = $fields['searchValue'];
            $query->Where(function ($query) use ($columns, $searchValue) {
                $arrayWord = explode(' ', trim($searchValue));
                foreach ($arrayWord as $value) {
                    $query->orWhere('users.name', 'like', '%'.$value.'%');
                    $query->orWhere('users.email', 'like', '%'.$value.'%');
                    $query->orWhere('products.title', 'like', '%'.$value.'%');
                    $query->orWhere('products.text', 'like', '%'.$value.'%');
                    $query->orWhere('shops.title', 'like', '%'.$value.'%');
                }
            });
            return $query->get();
        }
        else return $query->limit($fields['limit'])->offset($fields['offset'])->get();
    }
    
    public static function queryWhere($query = false, $fields = false, $shop_type = false){
		$shop_id = $fields['shop_id'];
        $category_id = $fields['category_id'];
		
		if(!$query) $query = Products::orderBy('id', 'desk');
			
		$query = $query->where('products.shop_type_id', '=', $shop_type)
				->where('products.del', '=', 1);

		if(!$fields['date_remove']) {
			$query = $query->where('products.date_remove', '>', date('Y-m-d H:i:s'));
		}
		
		$query->when($shop_id, function ($query) use ($shop_id) {
			return $query->where('products.shop_id', $shop_id);
		})
		->when($category_id, function ($query) use ($category_id) {
			return $query->where('products.category_id', $category_id);
		});

		return $query;
    }
    
    //обновить рейтинг товара и количество отзывов
    public static function updateRating($product_id, $rating, $countReviews){
        return Products::where('id', $product_id)->update([
            'rating' => $rating,
            'countReviews' => $countReviews
        ]);
    }
    
    public static function getById($id){
        return Products::where('id', '=', $id)->firstOrFail();
    }
    
    public static function add($request, $images = ''){
        return Products::insertGetId([
            'title' => $request->title,
            'user_id' => Auth::user()->id,
            'category_id' => $request->category_id,
            'shop_id' => $request->shop_id,
            'text' => $request->text, 
            'status' => $request->status,
            'price' => $request->price,
            'discount' => $request->discount,
            'start_discount' => $request->start_discount,
            'end_discount' => $request->end_discount,
            'shop_type_id' => $request->shop_type_id,
            'images' => $images,
            'date_remove' => $request->date_remove,
        ]);
    }
    
    public static function edit($request, $images = null){
        if(!$images) $images = null;
        
        $update = [
            'title' => $request->title,
            'text' => $request->text,
            'category_id' => $request->category_id,
            'shop_id' => $request->shop_id,
            'status' => $request->status,
            'price' => $request->price,
            'discount' => $request->discount,
            'start_discount' => $request->start_discount,
            'end_discount' => $request->end_discount,
            'images' => $images,
            'date_remove' => $request->date_remove,
        ];
        return Products::where('id', $request->product_id)->update($update);
    }
    
    public static function editStatus($request){
        $update = [
            'status' => $request->status
        ];
        return Products::where('id', $request->id)->update($update);
    }
    
    public static function remove($id){
        $update = [
            'del' => 2
        ];
        return Products::where('id', $id)->update($update);
    }
    
    public static function getLastProduct(){
        return Products::orderBy('id', 'desc')
                ->where('del', '=', 1)
                ->firstOrFail();
    }
}