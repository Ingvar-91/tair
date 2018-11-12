<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Auth;

class News extends Model{
    
    //получить данные для DateTables
    public static function getDataForDataTables($fields){
        $query = News::orderBy($fields['nameColumn'], $fields['dirOrder'])
                ->leftJoin('users', 'news.user_id', '=', 'users.id')
                ->addSelect(
                        'news.*',
                        'users.email',
                        'users.name'
                        );
        
        if($fields['searchValue']){//если задана строка поиска
            $columns = $fields['columns'];
            $searchValue = $fields['searchValue'];
            $query->Where(function ($query) use ($columns, $searchValue) {
                $arrayWord = explode(' ', trim($searchValue));
                foreach ($arrayWord as $value) {
                    $query->orWhere('users.name', 'like', '%'.$value.'%');
                    $query->orWhere('users.email', 'like', '%'.$value.'%');
                    $query->orWhere('news.title', 'like', '%'.$value.'%');
                    $query->orWhere('news.text', 'like', '%'.$value.'%');
                }
            });
            return $query->get();
        }
        else return $query->limit($fields['limit'])->offset($fields['offset'])->get();
    }
    
    public static function getDataById($request){
        return News::where('id', '=', $request->id)->first();
    }
    
    public static function add($request, $preview = ''){
        return News::insert([
            'title' => $request->title,
            'user_id' => Auth::user()->id,
            'text' => $request->text, 
            'status' => $request->status,
            'created_at' => $request->created_at,
            'preview' => $preview
        ]);
    }
    
    public static function edit($request, $preview = ''){
        return News::where('id', $request->id)->update([
            'title' => $request->title,
            'text' => $request->text, 
            'status' => $request->status,
            'created_at' => $request->created_at
        ]);
    }
    
    //удалить юзера
    public static function remove($request){
        return News::where('id', '=', $request->id)->delete();
    }
}