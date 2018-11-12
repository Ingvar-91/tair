<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Admin\News;
use Auth;

use App\Files\NewsFiles;
use App\Files\CkeditorFiles;

class NewsController extends Controller {
    
    use CkeditorFiles;
    use NewsFiles;
    
    const tmpl = 'admin/news/';//путь до шаблонов
    
    public function index(Request $request) {
        if ($request->ajax()) {
            $fields = $this->getFieldsDataTables($request); //получаем значения полей от плагина dataTables при ajax запросе
            $items = News::getDataForDataTables($fields); //получаем данные для DataTables
            if ($items) {
                foreach ($items as $item) {
                    $item->actions = view(self::tmpl . 'data-table-action', ['id' => $item->id])->render();
                    $item->status = view(self::tmpl . 'data-table-status', ['status' => $item->status])->render();
                }
                $recordsTotal = News::count();
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
    
    //удалить запись
    public function remove(Request $request){
        if ($request->ajax()) {
            $post = News::getDataById($request);
            /*сравниваем роли, если у авторизованного юзера в админке роль выше роли юзера написавшего комментарий, тогда редактирование разрешаем. В ином лучае отсылаем сообщение о том что нет доступа*/
            if($post->role){
                if(Auth::user()->role < $post->role){
                    return response()->json(['warning' => true, 'message' => 'У вас недостаточно прав для удаления этой записи']);
                }
            }

            $result = News::remove($request);
            return response()->json(['error' => empty($result)]);
        }
    }
    
    //форма добавления новой записи
    public function addForm(){
        return view(self::tmpl.'add', $this->data);
    }
    
    //добавить запись
    public function add(Request $request){
        if ($request->ajax()) {
            if ($request->status == 1) {//если запись помечается как опубликованная
                if (Auth::user()->role < 5) {//проверем что публикует администратор, в ином случае возвращаем false
                    return false;
                }
            }
            
            //загружаем изображения
            $fileNames = '';
            if($request->hasFile('images')){
                $fileNames = $this->uploadPreviewNews($request->file('images'));
            }
            
            $result = News::add($request, $fileNames);
            return response()->json(['error' => empty($result)]);
        }
    }
    
    //форма редактирования записи
    public function editForm(Request $request){
        $this->data['news'] = News::getDataById($request);
        return view(self::tmpl.'edit', $this->data);
    }
    
    //сохранить изменения записи
    public function edit(Request $request){
        if ($request->ajax()) {
            if ($request->status == 1) {//если запись помечается как опубликованная
                if (Auth::user()->role < 5) {//проверем что публикует администратор, в ином случае возвращаем false
                    return false;
                }
            }
            $result = News::edit($request);
            return response()->json(['error' => empty($result)]);
        }
    }
    
    public function addImage(Request $request){
        if($request->hasFile('upload')){
            $nameFile = $this->uploadCkeditorFiles($request->file('upload'));
            $path = '/'.config('filesystems.ckeditor').$nameFile;
            return "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($request->CKEditorFuncNum, '$path');</script>";
        }
    }
    
}
