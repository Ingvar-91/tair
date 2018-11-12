<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;

use App\Http\Models\Admin\CharacteristicsName;
use App\Http\Models\Admin\Filter;

use Auth;
use DB;

class FilterController extends Controller {
    
    const tmpl = 'admin/filter/';
    
    public function index(Request $request){
        //
        $characteristicsName = CharacteristicsName::getByShopType($request->shop_type);
        $filter = Filter::getByShopType($request->shop_type);
        foreach($characteristicsName as $characteristicName){
            $characteristicName->check = false;
            foreach($filter as $val){
                if($characteristicName->id == $val->characteristics_name_id) $characteristicName->check = true;
            }
        }
        //
        $this->data['characteristicsName'] = $characteristicsName;
        
        return view(self::tmpl.'index', $this->data);
        
        /*if($request->ajax()){
            $resultArray = [];
            $charName = $this->collectArray(CharacteristicsName::index($request), 'id');
            if($request->product_id){
                $charsProduct = Characteristics::getCharsProduct($request->product_id);
                foreach ($charName as $key => $val) {
                    if(array_key_exists($val->id, $charsProduct)){
                        if(isset($charName[$charName[$val->id]->parent_id])){
                            $charName[$charName[$val->id]->parent_id]->value = $val->name;
                            $charName[$charName[$val->id]->parent_id]->child_id = $val->id;
                        }
                    }
                }
            }
            $resultArray['charName'] = $this->buildTree($charName);
            return response()->json($resultArray);
        } */
    }
    
    public function edit(Request $request){
        //
        $characteristics_name = collect($request->characteristics_name);
        $filter = Filter::getByShopType($request->shop_type);
        
        $filterPluck = $filter->pluck('characteristics_name_id');
        //вычисляем расхождения массивов для удаления
        $removeFilter = $filterPluck->diff($characteristics_name);
        //вычисляем расхождения массивов для добавления
        $addFilter = $characteristics_name->diff($filterPluck);

        $removeArrIds = [];
        foreach($removeFilter as $id){
            foreach($filter as $val){
                if($id == $val->characteristics_name_id) $removeArrIds[] = $val->id;
            }
        }
        //
        
        try{
            \DB::beginTransaction();//начало транзакции

            Filter::addFilter($addFilter, $request->shop_type);
            Filter::removeInId($removeArrIds);

            \DB::commit();//конец транзакции
            return redirect()->back()->with('message-success', 'Данные успешно обновлены.');
        }
        catch (\Exception $e){
            \DB::rollback();//Отмена транзакции и изменений, вызванных её выполнением
            return redirect()->back()->with('message-error', 'Произошла ошибка при обновлении данных.');
        }
        
    }
    
    public function add(Request $request){
        
    }
    
    public function remove(Request $request){
        
    }
    
}