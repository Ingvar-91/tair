<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Site\Controller;
use Illuminate\Http\Request;

use App\Http\Models\Site\Orders;
use App\Http\Models\Site\Chars;
use App\Http\Models\Site\CharsProducts;

use App\Helpers\Helper;

use Auth;

class OrdersController extends Controller {

    const tmpl = 'site/orders/';
    
    public function index(){
        $this->data['orders'] = Orders::getOrdersByUser(Auth::user()->id, [3, 4]);
        return view(self::tmpl.'index', $this->data);
    }
    
    public function currentOrder(Request $request){
        $this->data['order'] = Orders::getOrderById($request);
        
        //получаем опции для товаров
        if(isset($this->data['order']->products)){
            foreach ($this->data['order']->products as $i => $product){
                $charsIdArray = unserialize($product->chars);
                $props = collect();
                if($charsIdArray){
                    $chars = Chars::getByInId($charsIdArray);
                    $props->push($chars);
                    $props->push(Chars::getParents($chars));
                    $props = $this->buildTree($props->collapse());
                    //
                    $product->props = $props;
                }
            }
        }
        
        return view(self::tmpl.'current-order', $this->data);
    }
    
    public function currentOrderPrint(Request $request){
        $this->data['order'] = Orders::getOrderById($request);
        
        //получаем опции для товаров
        foreach ($this->data['order']->products as $i => $product){
            $charsIdArray = unserialize($product->chars);
            $props = collect();
            $chars = Chars::getByInId($charsIdArray);
            $props->push($chars);
            $props->push(Chars::getParents($chars));
            $props = $this->buildTree($props->collapse());
            //
            $product->props = $props;
        }
        
        return view(self::tmpl.'current-order-print', $this->data);
    }
    
    public function currentOrders(Request $request){
        $this->data['orders'] = Orders::getOrdersByUser(Auth::user()->id, [1, 2]);
        return view(self::tmpl.'current-orders', $this->data);
    }
    
}
