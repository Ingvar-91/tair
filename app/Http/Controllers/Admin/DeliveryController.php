<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;
use Auth;

use App\Http\Models\Admin\Delivery;

class DeliveryController extends Controller {

    //const tmpl = 'admin/delivery/'; //путь до шаблонов
    /*
    public function index(Request $request) {
        if ($request->ajax()) {
            $fields = $this->getFieldsDataTables($request); //получаем значения полей от плагина dataTables при ajax запросе
            $items = Districts::getDataForDataTables($fields); //получаем данные для DataTables
            if ($items) {
                foreach ($items as $item) {
                    $item->actions = view(self::tmpl . 'data-table-action', ['id' => $item->id])->render();
                }
                $recordsTotal = Districts::queryWhere(false, $fields)->count();
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
    
    //форма добавления новой записи
    public function addForm(){
        $this->data['cities'] = Cities::getAll();
        return view(self::tmpl.'add', $this->data);
    }
    
    //добавить запись
    public function add(Request $request){
        $result = Districts::add($request);
        
        if($result) return redirect()->back()->with('message-success', 'Данные успешно добавлены.');
        else return redirect()->back()->with('message-error', 'Произошла ошибка при добавлении данных.');
    }
    
    //форма редактирования записи
    public function editForm(Request $request){
        $this->data['district'] = Districts::getById($request->id);
        $this->data['cities'] = Cities::getAll();
        return view(self::tmpl.'edit', $this->data);
    }
    
    //сохранить изменения записи
    public function edit(Request $request){

        $result = Districts::edit($request);
        if($result) return redirect()->back()->with('message-success', 'Данные успешно обновлены.');
        else return redirect()->back()->with('message-error', 'Произошла ошибка при обновлении данных.');
    }
    
    public function remove(Request $request){
        if ($request->ajax()) {
            $result = Districts::remove($request);
            return response()->json(['error' => empty($result)]);
        }
    }
    */
}
