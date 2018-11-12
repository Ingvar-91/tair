<?php

namespace App\Validation\Admin;

use Illuminate\Http\Request;
use Validator;

trait UserValidation{
    
    //создание юзера
    private function validCreateUser($request){
        $validator = Validator::make($request->all(), [
                'email' => 'required|email|max:255|unique:users,email',
                'name' => 'nullable|string|max:255',
                'lastname' => 'nullable|string|max:255',
                'patronymic' => 'nullable|string|max:255',
                'password' => 'alpha_dash|required|min:6|confirmed|max:40',
                'image' => 'nullable|mimes:jpeg,gif,png|max:5120',//не больше 5МБ(значения исчисляются в кб)
                'phone' => 'nullable|max:18|regex:/^([0-9\s\-\+\(\)]*)$/',
                'role' => 'required'
            ]
        );
        
        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }
    }
    
    //редактирование пользователя
    private function validEditUser($request, $user){
        $rules = [
            'name' => 'nullable|string|max:255',
            'lastname' => 'nullable|string|max:255',
            'patronymic' => 'nullable|string|max:255',
            'image' => 'nullable|mimes:jpeg,gif,png|max:5120',//не больше 5МБ(значения исчисляются в кб)
            'phone' => 'nullable|max:18|regex:/^([0-9\s\-\+\(\)]*)$/',
            'role' => 'required'
        ];
        
        if($user->email == $request->email) $rules['email'] = 'required|email|max:255';
        else $rules['email'] = 'required|email|max:255|unique:users,email';
        
        if($request->password) $rules['password'] = 'alpha_dash|required|min:6|confirmed|max:40';
        
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }
    }

}