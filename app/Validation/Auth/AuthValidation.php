<?php

namespace App\Validation\Auth;

use Illuminate\Http\Request;
use Validator;

trait AuthValidation{
    
    //валидация входных данных от пользователя при регистрации
    private function validReg($request) {
        $validator = Validator::make($request->all(), [
                'email' => 'required|email|max:255|unique:users,email',
                'password' => 'alpha_dash|required|min:6|confirmed|max:255',
                'name' => 'nullable|string|max:255',
                'lastname' => 'nullable|string|max:255',
                'patronymic' => 'nullable|string|max:255',
                'address' => 'nullable|string|max:255',
                'image' => 'nullable|mimes:jpeg,gif,png|max:5120',//не больше 5МБ(значения исчисляются в кб)
                'phone' => 'nullable|max:18|regex:/^([0-9\s\-\+\(\)]*)$/'
            ], $this->messages()
        );

        if ($validator->fails()) {
            return $validator;
            //$this->throwValidationException($request, $validator);
        }
    }
    
    //валидация входных данных от пользователя при авторизации
    protected function validLogin($request) {
        $validator = Validator::make($request->all(), [
                'email' => 'required|email|max:255|exists:users,email',
                'password' => 'required|max:255',
            ], $this->messages());
        
        if ($validator->fails()){
            return $validator;
            //$this->throwValidationException($request, $validator);
        }
        else return $validator;
    }
    
    private function validCaptcha($request){
        $validator = Validator::make($request->all(), ['captcha' => 'required|captcha'], $this->messages());
        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }
    }
    
    //сообщения об ошибках валидации
    private function messages(){
        return [
            'name.required' => 'Имя не должно быть пустым.',
            'name.alpha_dash' => 'Имя может содержать только буквы, цифры и дефисы.',
            'name.exists' => 'Такого пользователя не существует.',
            'name.unique' => 'Пользователь с таким именем уже существует.',
            'email.unique' => 'Пользователь с таким E-mail уже существует.',
            'email.required' => 'Поле E-mail не должно быть пустым.',
            'email.exists' => 'Такого пользователя не существует.',
            'password.required' => 'Поле пароля не должно быть пустым.',
            'password.confirmed' => 'Пароли не совпадают.',
            'password.min' => 'Пароль должен иметь длину не меньше 6 символов.',
            'password.alpha_dash' => 'Пароль может содержать только буквы, цифры и дефис.',
            'captcha.required' => 'Введите проверочный код.',
            'captcha.captcha' => 'Проверочный код не совпадает.'
        ];
    }
    
}