<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;
use Redirect;
use Auth;
use App\Http\Models\Admin\ProductComments;
use App\Http\Models\Admin\Users;

use Mail;

class ProductCommentsController extends Controller {

    const tmpl = 'admin/comments/'; //путь до шаблонов

    public function index(Request $request) {
        if ($request->ajax()) {
            $fields = $this->getFieldsDataTables($request); //получаем значения полей от плагина dataTables при ajax запросе
            $items = ProductComments::getDataForDataTables($fields); //получаем данные для DataTables
            if ($items) {
                foreach ($items as $item) {
                    if(!$item->user_name){
                        $item->user_name = $item->name;
                    }
                    $item->actions = view(self::tmpl . 'data-table-action', ['id' => $item->id, 'first_parent_id' => $item->first_parent_id, 'user_id' => $item->user_id])->render();
                    $item->status = view(self::tmpl . 'data-table-status', ['id' => $item->id, 'status' => $item->status])->render();
                }
                $recordsTotal = ProductComments::count();
                if ($request->input('search')['value']) $recordsFiltered = $items->count();
                else $recordsFiltered = $recordsTotal;
                return response()->json([
                        'data' => $items,
                        'recordsTotal' => $recordsTotal,
                        'recordsFiltered' => $recordsFiltered
                ]);
            }
        }
        return view(self::tmpl . 'index', $this->data);
    }
    
    public function add(Request $request) {
        if ($request->ajax()) {
            $result = ProductComments::add($request);
            
            //отправка почты если есть id юзера
            if($request->user_id){
                $data = Users::getByid($request->user_id);
                
                Mail::send('emails/comment', array(
                    'site_name' => config('app.name'), 
                    'name' => $data->name, 
                    'email' => $data->email,
                    'text' => $request->text
                ), function($message) use ($data){
                    $message->from(config('mail.from.address'));//от кого
                    $message->to($data->email);//кому отправляем
                    $message->subject('Ответ на комментарий');//тема письма
                });
            }
            
            return response()->json(['error' => empty($result)]);
        }
    }

    public function edit(Request $request) {
        if ($request->ajax()) {
            $result = ProductComments::edit($request);
            return response()->json(['error' => empty($result)]);
        }
    }
    
    //сменить статус
    public function editStatus(Request $request) {
        if ($request->ajax()) {
            $result = ProductComments::editStatus($request);
            return response()->json(['error' => empty($result)]);
        }
    }

    //удалить комментарий
    public function remove(Request $request) {
        if ($request->ajax()) {
            $result = ProductComments::remove($request);
            return response()->json(['error' => empty($result)]);
        }
    }

    public function getComment(Request $request) {
        if ($request->ajax()) {
            $result = ProductComments::getDataById($request);
            return response()->json(['error' => empty($result), 'comment' => $result]);
        }
    }
    
    public function getAllHistoryComment(Request $request) {
        if ($request->ajax()) {
            $result = ProductComments::getAllHistoryComment($request);
            $result = $this->buildTree($result);
            return response()->json(['error' => empty($result), 'comments' => $result]);
        }
    }
    

}
