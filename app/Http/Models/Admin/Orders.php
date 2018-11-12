<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Orders extends Model{
    
    public $table = 'orders';
    
    //получить данные для DateTables
    public static function getDataForDataTables($fields){
        $query = Orders::orderBy($fields['nameColumn'], $fields['dirOrder'])
                ->leftJoin('delivery_methods', 'orders.delivery_id', '=', 'delivery_methods.id')
                ->addSelect(
                    'orders.*',
                    'delivery_methods.title as delivery_title'
                )
                ->leftJoin('payment_methods', 'orders.payment_id', '=', 'payment_methods.id')
                ->addSelect(
                    'orders.*',
                    'payment_methods.title as payment_title'
                );
        
        if($fields['searchValue']){//если задана строка поиска
            $columns = $fields['columns'];
            $searchValue = $fields['searchValue'];
            $query->Where(function ($query) use ($columns, $searchValue) {
                $arrayWord = explode(' ', trim($searchValue));
                foreach ($arrayWord as $value) {
                    $query->orWhere('id', 'like', '%'.$value.'%');
                    $query->orWhere('fio', 'like', '%'.$value.'%');
                    $query->orWhere('email', 'like', '%'.$value.'%');
                    $query->orWhere('phone', 'like', '%'.$value.'%');
                    $query->orWhere('address', '%'.$value.'%');
                    $query->orWhere('delivery', 'like', '%'.$value.'%');
                    $query->orWhere('payment', 'like', '%'.$value.'%');
                }
            });
            return $query->get();
        }
        else return $query->limit($fields['limit'])->offset($fields['offset'])->get();
    }
    
    public static function getById($request){
        return Orders::where('orders.id', $request->id)
                /*->leftJoin('users', 'orders.shop_id', '=', 'users.id')
                ->addSelect(
                    'orders.*',
                    'users.name as user_name',
                    'users.lastname as user_lastname',
                    'users.patronymic as user_patronymic'
                )*/
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
    }
    
    public static function edit($request){
        return Orders::where('id', $request->id)->update([
            'status' => $request->status,
            'status_at' => date('Y-m-d H:i:s')
        ]);
    }
    
}