<?php

namespace App\Validation\Site;

use Illuminate\Http\Request;
use Validator;

trait ContactsValidation{  
    
    private function validContacts($request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'theme' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'text' => 'required|string|max:2048',
        ]);
        
        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }
    }
    
}