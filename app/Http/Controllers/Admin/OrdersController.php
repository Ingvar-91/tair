<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;

use App\Http\Models\Admin\Orders;
use App\Http\Models\Admin\Order_product;
use App\Http\Models\Admin\Chars;
use App\Http\Models\Admin\CharsProducts;

use Auth;

use App\Helpers\Helper;

class OrdersController extends Controller {
    
    const tmpl = 'admin/orders/';
    
    public function index(Request $request){
        if ($request->ajax()) {
            $fields = $this->getFieldsDataTables($request); //получаем значения полей от плагина dataTables при ajax запросе
            $items = Orders::getDataForDataTables($fields); //получаем данные для DataTables
            if ($items) {
                foreach ($items as $item) {
                    $statusArray = config('orders.status');
                    $item->order_num = str_pad($item->id, 6, '0', STR_PAD_LEFT);
                    
                    if($item->delivery == 1) $item->delivery_name = 'Самовывоз';
                    elseif($item->delivery == 2) $item->delivery_name = 'Курьерская доставка '.$item->delivery_price.' тг.';
                            
                    $item->status = view(self::tmpl . 'data-table-status', ['statusArray' => $statusArray, 'status' => $item->status])->render();
                    $item->actions = view(self::tmpl . 'data-table-action', ['id' => $item->id])->render();
                }
                $recordsTotal = Orders::count();
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
    
    public function edit(Request $request){
        $result = Orders::edit($request);
        
        if($result) return redirect()->back()->with('message-success', 'Данные успешно обновлены.');
        else return redirect()->back()->with('message-error', 'Произошла ошибка при обновлении данных.');
    }

    
    public function editForm(Request $request){
        $this->data['order'] = Orders::getById($request);
        $this->data['products'] = Order_product::index($request);
        
        //получаем опции для товаров
        //$tradeOffers = TradeOffers::getAll();
        
        foreach ($this->data['products'] as $i => $product){
            $charsIdArray = unserialize($product->chars);
            
            //получаем свойства товара
            $props = collect();
            $chars = Chars::getByInId($charsIdArray);
            $props->push($chars);
            $props->push(Chars::getParents($chars));
            $props = $this->buildTree($props->collapse());
            //
            $product->props = $props;
        }
        
        $this->data['total'] = 0;
        if($this->data['products']){
            foreach ($this->data['products'] as $key => $val) {
                $this->data['total'] += $val->count * $val->price;
            }
        }
        return view(self::tmpl . 'edit', $this->data);
    }
    
}