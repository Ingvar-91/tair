<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Http\Models\Admin\ShopsType;

class Controller extends BaseController {

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    protected $data = [];

    public function __construct(){
        $this->data['shopsType'] = ShopsType::getAll();
    }
    
    //
    protected function getFieldsDataTables($request){
        $fields['limit'] = $request->input('length');
        $fields['offset'] = $request->input('start');
        $fields['columns'] = $request->input('columns');
        $fields['order'] = $request->input('order');
        $fields['order'] = array_shift($fields['order']);
        $fields['nameColumn'] = $fields['columns'][$fields['order']['column']]['data'];// зная номер колонки, получаем её название
        $fields['dirOrder'] = $fields['order']['dir'];// order ASK/DESK
        $fields['searchValue'] = $request->input('search')['value'];
		$fields['shop_id'] = $request->input('shop_id');
		$fields['category_id'] = $request->input('category_id');
		$fields['date_remove'] = $request->input('date_remove');
        return $fields;
    }
    
    //
    /*function buildTree($elements, $parentId = 0) {
        $branch = array();

        foreach ($elements as $element) {
            if ($element->parent_id == $parentId) {
                $children = $this->buildTree($elements, $element->id);
                if ($children) {
                    $element->child = $children;
                }
                $branch[] = $element;
            }
        }
        return $branch;
    }*/
    
    function buildTree($elements, $parentId = 0, $nameVariable = 'parent_id') {
        $branch = array();

        foreach ($elements as $element) {
            if ($element->$nameVariable == $parentId) {
                $children = $this->buildTree($elements, $element->id);
                if ($children) {
                    $element->child = $children;
                }
                $branch[] = $element;
            }
        }
        return $branch;
    }
	
    protected function collectArray($array, $nameKey) {
        $arrayNew = [];
        foreach($array as $key => $val){
            $arrayNew[$val->$nameKey] = $val;
        }
        return $arrayNew;
    }

    //получить массив где ключами будут id записей
    /*protected function arrayWhereIdKeys($array){
        $arr = [];
        foreach ($array as $key => $value) {
            $arr[$value->id] = $value;
        }
        return $arr;
    }*/
    
}
