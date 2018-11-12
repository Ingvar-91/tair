<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;
use Auth;

use App\Http\Models\Admin\ShopCategories;
use App\Http\Models\Admin\ShopsType;


class ShopsTypeController extends Controller {
    
    const tmpl = 'admin/shops_type/';

    public function index(Request $request) {
        if ($request->ajax()) {
            $fields = $this->getFieldsDataTables($request); //получаем значения полей от плагина dataTables при ajax запросе
            $items = ShopsType::getDataForDataTables($fields); //получаем данные для DataTables
            if ($items) {
                foreach ($items as $item) {
                    $item->actions = view(self::tmpl . 'data-table-action', ['id' => $item->id])->render();
                }
                $recordsTotal = ShopsType::queryWhere(false, $fields)->count();
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
    
    /*public function addForm(){ 
        return view(self::tmpl.'add', $this->data);
    }*/
    
    /*public function add(Request $request){
        $result = ShopCategories::add($request);
        if($result) return redirect()->back()->with('message-success', 'Данные успешно добавлены.');
        else return redirect()->back()->with('message-error', 'Произошла ошибка при добавлении данных.');
    }*/
    
    //форма редактирования записи
    /*public function editForm(Request $request){
        $this->data['shop_category'] = ShopCategories::getById($request->id);
        return view(self::tmpl.'edit', $this->data);
    }*/
    
    //сохранить изменения записи
    /*public function edit(Request $request){
        $result = ShopCategories::edit($request);
        if($result) return redirect()->back()->with('message-success', 'Данные успешно обновлены.');
        else return redirect()->back()->with('message-error', 'Произошла ошибка при обновлении данных.');
    }*/
    
    /*public function remove(Request $request){
        if ($request->ajax()) {
            $result = ShopCategories::remove($request);
            return response()->json(['error' => empty($result)]);
        }
    }*/

}
