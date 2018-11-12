<?php

namespace App\Http\Models\Site;

use Illuminate\Database\Eloquent\Model;

use App\Http\Models\Site\Products;
use DB;

class ProductCategories extends Model{
    
    public $timestamps = false;
    public $table = 'product_categories';
    
    public static function index($shop_id = false){   
        return Products::select('product_categories.title', 'product_categories.id', 'product_categories.parent_id', 'product_categories.image', DB::raw('count(*) as `count`'))
                ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
                ->leftJoin('shops', 'products.shop_id', '=', 'shops.id')
                ->groupBy('products.category_id')
                ->where('products.status', 2)
                ->where('products.del', 1)
                ->where('products.date_remove', '>', date('Y-m-d H:i:s'))
                ->where('shops.status', 2)
                ->when($shop_id, function ($query) use ($shop_id){
                    return $query->where('products.shop_id', $shop_id);
                })
                ->get();   
    }
    
    public static function getAll(){
        return ProductCategories::orderBy('id', 'asc')->get();
    }
    
    public static function getById($id){
        return ProductCategories::where('id', '=', $id)->first();
    }
    
    public static function getByIdIn($array){
        return ProductCategories::whereIn('id', $array)->get();
    }

    public static function add($request){
        if($request->title and $request->parent_id){
            return ProductCategories::insert([
                'title' => $request->title,
                'parent_id' => $request->parent_id
            ]);
        }
    }
    
    public static function edit($request){
        $result = ProductCategories::where('id', '=', $request->id)->update([
            'title' => $request->title,
            'parent_id' => $request->parent_id
        ]);
        if($result) return true;
    }
    
    public static function remove($request){
        $result = ProductCategories::where('id', '=', $request->id)->delete();
        if($result){//если родитель бы удален, удалем и потомков
            self::removeChilds([$request->id]);
        }
        return $result;
    }
    
    public static function removeChilds($ids){
        $array = ProductCategories::whereIn('parent_id', $ids)->get();
        if(isset($array)){
            $ids = [];
            foreach ($array as $key => $val){
                $ids[] = $val->id;
            }
            $delete = ProductCategories::whereIn('id', $ids)->delete();
            if($delete){
                self::removeChilds($ids);
            }
        }
    }
    
    public function parent()
    {
        return $this->belongsTo($this, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany($this, 'parent_id');
    }
    
}