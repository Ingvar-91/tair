<?php

namespace App\Http\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Auth;

class PaymentMethods extends Model{
    
    public $timestamps = false;
    public $table = 'payment_methods';
    
    public static function getById($id){
        return PaymentMethods::where('id', '=', $id)->firstOrFail();
    }
    
    public static function getAll(){
        return PaymentMethods::get();
    }

}