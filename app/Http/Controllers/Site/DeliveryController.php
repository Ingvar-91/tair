<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Site\Controller;

class DeliveryController extends Controller {

    const tmpl = 'site/delivery/';

    public function index() {
        
        /*$phone = '+7(707)621-8305';
        //$this->SendSms($phone, config('mobizon.messages.order'));
        
        $mobizon = new MobizonSend();
        dd($mobizon);
        $mobizon->SendSms($phone, config('mobizon.messages.order'));*/
        
        return view(self::tmpl . 'index', $this->data);
    }
    
    

}
