<?php

namespace App\Validation\Site;

use Illuminate\Http\Request;
use Validator;

trait UsersValidation{
    
    //редактирование пользователя
    private function validEditUser($request, $user){
        $rules = [
            'name' => 'nullable|string|max:255',
            'lastname' => 'nullable|string|max:255',
            'patronymic' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'home' => 'nullable|string|max:255',
            'apartment' => 'nullable|string|max:255',
            'floor' => 'nullable|string|max:255',
            'intercom' => 'nullable|string|max:255',
            'building' => 'nullable|string|max:255',
            'entrance' => 'nullable|string|max:255',
            'image' => 'nullable|mimes:jpeg,gif,png|max:5120',//не больше 5МБ(значения исчисляются в кб)
            'phone' => 'nullable|max:18|regex:/^([0-9\s\-\+\(\)]*)$/'
        ];
        
        if(isset($request->nickname)){
            if($user->nickname == $request->nickname) $rules['nickname'] = 'required|alpha_dash|max:255';
            else $rules['nickname'] = 'required|alpha_dash|max:255|unique:users,nickname';
        }
        
        if($user->email == $request->email) $rules['email'] = 'required|email|max:255';
        else $rules['email'] = 'required|email|max:255|unique:users,email';
        
        if($request->password) $rules['password'] = 'alpha_dash|required|min:6|confirmed|max:40';
        
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }
    }

}