<?php

namespace App\Http\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Hash;
use Auth;

class Users extends Model{
    
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
        'verification',
        'remember_token'
    ];
    
    protected $fillable = ['nickname', 'email', 'password', 'phone', 'image', 'role', 'verification', 'address'];
    
    //получить юзера
    public static function getById($id){
        return Users::where('id', '=', $id)->firstOrFail();
    }
    
    public static function add($request, $imageName = '', $verification_token){
        return Users::insertGetId([
            'name' => $request->name, 
            'lastname' => $request->lastname, 
            'patronymic' => $request->patronymic, 
            'email' => mb_strtolower($request->email, 'UTF-8'),
            'phone' => $request->phone, 
            'password' => bcrypt(mb_strtolower($request->password, 'UTF-8')),
            'street' => $request->street,
            'home' => $request->home,
            'apartment' => $request->apartment,
            'floor' => $request->floor,
            'intercom' => $request->intercom,
            'building' => $request->building,
            'entrance' => $request->entrance,
            'verification_token' => $verification_token,
            'verification' => 1,//по умолчанию верифицирован
            'image' => $imageName
        ]);
    }
    
    public static function verifyUser($id){
        return Users::where('id', $id)->update([
            'verification' => 1,
            'verification_token' => null,
        ]);
    }
    
    //редактировать юзера
    public static function edit($request, $imageName = '', $id){
        $update = [
            'name' => $request->name, 
            'lastname' => $request->lastname, 
            'patronymic' => $request->patronymic, 
            'email' => mb_strtolower($request->email, 'UTF-8'),
            'phone' => $request->phone, 
            'street' => $request->street,
            'home' => $request->home,
            'apartment' => $request->apartment,
            'floor' => $request->floor,
            'intercom' => $request->intercom,
            'building' => $request->building,
            'entrance' => $request->entrance,
            'image' => $imageName
        ];
        
        if($request->password) $update['password'] = Hash::make(mb_strtolower($request->password, 'UTF-8'));
        
        return Users::where('id', $id)->update($update);
    }
    
    //удалить юзера
    public static function remove($request){
        return Users::where('id', '=', $request->id)->delete();
    }
    
    public static function getByEmail($email){
        return Users::where('email', '=', $email)->first();
    }
    
}