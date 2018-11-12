<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;
use Auth;

use App\Http\Models\Admin\Districts;
use App\Http\Models\Admin\DistrictsMinPrice;
use App\Http\Models\Admin\Cities;
use App\Http\Models\Admin\Delivery;
use App\Http\Models\Admin\Shops;

class DistrictsController extends Controller {

    const tmpl = 'admin/districts/'; //путь до шаблонов

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
        $this->data['shops'] = Shops::getAll();
        return view(self::tmpl.'add', $this->data);
    }
    
    //добавить запись
    public function add(Request $request){
        $district_id = Districts::add($request);
        if($district_id){
            if(count($request->min_price)){
                DistrictsMinPrice::add($request, $district_id);
                Delivery::add($request, $district_id);
            }
            return redirect()->back()->with('message-success', 'Данные успешно добавлены.');
        }
        return redirect()->back()->with('message-error', 'Произошла ошибка при добавлении данных.');
    }
    
    //форма редактирования записи
    public function editForm(Request $request){
        $this->data['district'] = Districts::getById($request->id);
        $this->data['cities'] = Cities::getAll();
        $this->data['shops'] = Shops::getAll();
        $this->data['shipping'] = $this->collectArray(Delivery::getShipping($request->id), 'shop_id');
        $this->data['min_price'] = $this->collectArray(DistrictsMinPrice::getMinPrice($request->id), 'shop_id');
        return view(self::tmpl.'edit', $this->data);
    }
    
    //сохранить изменения записи
    public function edit(Request $request){
        $result = Districts::edit($request);
        
        if($result){
            DistrictsMinPrice::edit($request);
            Delivery::edit($request);
            return redirect()->back()->with('message-success', 'Данные успешно обновлены.');
        }
        return redirect()->back()->with('message-error', 'Произошла ошибка при обновлении данных.');
    }
    
    public function remove(Request $request){
        if ($request->ajax()) {
            $result = Districts::remove($request);
            return response()->json(['error' => empty($result)]);
        }
    }

}
