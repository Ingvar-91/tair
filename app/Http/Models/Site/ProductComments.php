<?php

namespace App\Http\Models\Site;

use Illuminate\Database\Eloquent\Model;

use Auth;

class ProductComments extends Model{
    
    public $table = 'product_comments';

    public static function getComments($product_id, $parent_id = 0, $offset = 0){
        $parents = ProductComments::orderBy('product_comments.id', 'ask')
                //->where('product_comments.status', '=', '2')
                ->where('product_comments.product_id', '=', $product_id)
                ->where('product_comments.parent_id', '=', $parent_id)
                ->leftJoin('users', 'product_comments.user_id', '=', 'users.id')
                ->addSelect(
                    'product_comments.*',
                    'users.name as user_name'
                )
                ->offset($offset)
                ->limit(10)
                ->get();
        
        $ids = [];
        foreach ($parents as $key => $value) {
            $ids[] = $value->id;
        }
        $childs = ProductComments::orderBy('product_comments.id', 'ask')
                //->where('product_comments.status', '=', '2')
                ->whereIn('product_comments.first_parent_id', $ids)
                ->leftJoin('users', 'product_comments.user_id', '=', 'users.id')
                ->addSelect(
                    'product_comments.*',
                    'users.name as user_name'
                )
                ->get();
        
        $collapsed = collect([$parents, $childs])->collapse()->all();
        
        return $collapsed;
    }
    
    public static function add($request){
        $insert = [
            'text' => $request->text,
            'product_id' => $request->product_id
        ];
        
        if(Auth::check()){
            $insert['user_id'] = Auth::user()->id;
        }
        else{
            $insert['name'] = $request->name;
        }
        
        if(isset($request->parent_id)) $insert['parent_id'] = $request->parent_id;
        if(isset($request->first_parent_id)) $insert['first_parent_id'] = $request->first_parent_id;
        
        return ProductComments::insertGetId($insert);
    }

    /*private function children(){
        return $this->hasMany(self::class, 'parent_id', 'id')->get();
        
    }*/
}