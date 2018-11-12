<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Hash;
use Auth;

class Users extends Model{
    
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    //protected $fillable = ['name', 'email', 'password', 'phone', 'image', 'role', 'verification'];
    
    //получить данные для DateTables
    public static function getDataForDataTables($fields){
        $query = Users::orderBy($fields['nameColumn'], $fields['dirOrder'])->where('role', '!=', 6)->where('id', '!=', Auth::user()->id);
        
        if($fields['searchValue']){//если задана строка поиска
            $columns = $fields['columns'];
            $searchValue = $fields['searchValue'];
            $query->Where(function ($query) use ($columns, $searchValue) {
                foreach ($columns as $key => $column) {
                    if ($column['searchable'] === 'true') {
                        $query->orWhere($column['data'], 'LIKE', "%$searchValue%");
                    }
                }
            });
            return $query->get();
        }
        else return $query->limit($fields['limit'])->offset($fields['offset'])->get();
    }
    
    public static function queryWhere($query = false, $fields = false){
        if(!$query) $query = Users::orderBy('id', 'desk');
        
        return $query;
    }
    
    //добавить юзера
    public static function add($request, $image = ''){
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
            'verification' => 1,//так как юзер был создан в админке, он автоматически помечается как верифицированный
            'image' => $image,
            'role' => $request->role,
            'verification' => 1//так как юзер был создан в админке, он автоматически помечается как верифицированный
        ]);
    }
    
    //получить юзера
    public static function getById($id){
        return Users::where('id', '=', $id)->firstOrFail();
    }
    
    //редактировать юзера
    public static function edit($request, $image = ''){
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
            'image' => $image,
            'role' => $request->role
        ];
        
        if($request->password) $update['password'] = Hash::make(mb_strtolower($request->password, 'UTF-8'));
        
        return Users::where('id', $request->id)->update($update);
    }
    
    //удалить юзера
    public static function remove($request){
        return Users::where('id', '=', $request->id)->delete();
    }
    
    public static function userExist($email){
        return Users::where('email', '=', $email)->exists();
    }
    
}