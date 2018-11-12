<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Auth;

class ProductComments extends Model{
    
    public $table = 'product_comments';
    
    //получить данные для DateTables
    public static function getDataForDataTables($fields){
        $query = ProductComments::orderBy($fields['nameColumn'], $fields['dirOrder'])
                ->leftJoin('users', 'product_comments.user_id', '=', 'users.id')
                ->addSelect(
                    'product_comments.*',
                    'users.name as user_name'
                );
        
        if($fields['searchValue']){//если задана строка поиска
            $columns = $fields['columns'];
            $searchValue = $fields['searchValue'];
            $query->Where(function ($query) use ($columns, $searchValue) {
                $arrayWord = explode(' ', trim($searchValue));
                foreach ($arrayWord as $value) {
                    $query->orWhere('comments.name', 'like', '%'.$value.'%');
                    $query->orWhere('comments.text', 'like', '%'.$value.'%');
                }
            });
            return $query->get();
        }
        else return $query->limit($fields['limit'])->offset($fields['offset'])->get();
    }
    
    public static function add($request){
        return ProductComments::insert([
            'name' => Auth::user()->name,
            'text' => $request->text, 
            'parent_id' => $request->id,
            'first_parent_id' => $request->id,
            'status' => 1
        ]);
    }
    
    public static function editStatus($request){
        return ProductComments::where('id', $request->id)->update([
            'status' => $request->status
        ]);
    }
    
    public static function getDataById($request){
        return ProductComments::where('product_comments.id', '=', $request->id)
                ->leftJoin('users', 'product_comments.user_id', '=', 'users.id')
                ->addSelect(
                    'product_comments.*',
                    'users.name as user_name'
                )
                ->first(); 
    }
    
    //удаление записей
    public static function remove($request){
        return ProductComments::where('id', $request->id)->update([
            'status' => 3
        ]);
    }
    
    public static function edit($request){
        return ProductComments::where('id', $request->id)->update([
            'text' => $request->text
        ]);
    }
    
    //пометить как прочитанно
    public static function readComment($request){
        return ProductComments::where('id', $request->id)->update([
            'read' => 1
        ]);
    }
    
    //получить всю историю комментария
    public static function getAllHistoryComment($request){
        if($request->first_parent_id){
            $parentComments = ProductComments::where('product_comments.first_parent_id', '=', $request->first_parent_id)
                ->leftJoin('users', 'product_comments.user_id', '=', 'users.id')
                ->addSelect(
                    'product_comments.*',
                    'users.name as user_name'
                )
                ->get();
            $parentComment = ProductComments::where('product_comments.id', '=', $request->first_parent_id)
                    ->leftJoin('users', 'product_comments.user_id', '=', 'users.id')
                    ->addSelect(
                        'product_comments.*',
                        'users.name as user_name'
                    )
                    ->get();
            return collect([$parentComments, $parentComment])->collapse()->all();
        }
        else{
            $parentComment = ProductComments::where('product_comments.id', '=', $request->id)
                    ->leftJoin('users', 'product_comments.user_id', '=', 'users.id')
                    ->addSelect(
                        'product_comments.*',
                        'users.name as user_name'
                    )
                    ->get();
            $parentComments = ProductComments::where('product_comments.first_parent_id', '=', $request->id)
                    ->leftJoin('users', 'product_comments.user_id', '=', 'users.id')
                    ->addSelect(
                        'product_comments.*',
                        'users.name as user_name'
                    )
                    ->get();
            return collect([$parentComments, $parentComment])->collapse()->all();
        }
    }

}