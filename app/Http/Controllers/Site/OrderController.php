<?php
namespace App\Http\Controllers\Site;

use App\Http\Controllers\Site\Controller;
use Illuminate\Http\Request;

use App\Http\Models\Site\Products;
use App\Http\Models\Site\Order_product;
use App\Http\Models\Site\Orders;
use App\Http\Models\Site\Cities;
use App\Http\Models\Site\Districts;
use App\Http\Models\Site\DistrictsMinPrice;
use App\Http\Models\Site\Delivery;
use App\Http\Models\Site\PaymentMethods;
use App\Http\Models\Site\DeliveryMethods;
use App\Http\Models\Site\Chars;
use App\Http\Models\Site\CharsProducts;

use App\Helpers\Helper;
use Mail;
use Auth;

use DB;

use App\Jobs\SendEmailNewOrder;
use App\Jobs\SendSmsNewOrder;

//use App\MobizonLib\MobizonSend;

class OrderController extends Controller{

    const tmpl = 'site/order/';

    public function index(Request $request){
        $products = Products::getCart(Products::getCartIds(), $request->id);
        if(!count($products)) return redirect()->route('home');
        $this->data['cities'] = Cities::getAll();
        $this->data['cookieCart'] = Products::getCookieCart();

        $shop = $this->getShopInfo($products, $this->data['cookieCart']);
        
        $this->data['linkWhatsappShop'] = $shop->link_whatsapp;
        $this->data['mainPhoneShop'] = $shop->main_phone;
        $this->data['payment_methods'] = PaymentMethods::getAll();//Способы оплаты
        $this->data['delivery_methods'] = DeliveryMethods::getAll();//Способы доставки
        
        if($shop->min_price > $shop->total){
            return redirect()->route('home');
        }
        $this->data['shop'] = $shop;
        
        $map_2gis_url = parse_url($shop->map_2gis_url);
        $this->data['shop']->floors2gis = '';
        $this->data['shop']->firm2gis = '';
        if(isset($map_2gis_url['path'])){
            $param_2gis = explode('/', $map_2gis_url['path']);
            $floorsKey = array_search('floors', $param_2gis);
            $firmKey = array_search('firm', $param_2gis);
            if(isset($param_2gis[$floorsKey + 1]) and isset($param_2gis[$firmKey + 1])){
                $this->data['shop']->floors2gis = $param_2gis[$floorsKey + 1];
                $this->data['shop']->firm2gis = $param_2gis[$firmKey + 1];
            }
        }
        $this->data['shop'] = $shop;
        
        return view(self::tmpl.'index', $this->data);
    }
    
    private function getShopInfo($products, $cookieCart){
        $shop = new \stdClass();
        if(count($products)){
            foreach($products as $key => $val){
                //проверяем изображения и свойста товара
                if(Helper::getImg($val->images, 'products', 'small')){
                    $val->preview = Helper::getImg($val->images, 'products', 'small');
                }
                else{
                    $val->preview = '/img/no-image-1x1.jpg';
                }
                
                if($cookieCart[$val->id]->chars){
                    $charsIdArray = $cookieCart[$val->id]->chars;
                    $props = collect();
                    $chars = Chars::getByInId($charsIdArray);
                    $props->push($chars);
                    $props->push(Chars::getParents($chars));
                    $props = $this->buildTree($props->collapse());
                    //
                    $val->props = $props;
                }
                
                //
                $priceProduct = 0;
                if($val->del == 1){// если товар не удален
                    if(Helper::isDiscount($val->start_discount, $val->end_discount, $val->discount)){
                        $priceProduct = $cookieCart[$val->id]->count * $val->discount;
                    }
                    else{
                        if($val->price){
                            $priceProduct = $cookieCart[$val->id]->count * $val->price;
                        }
                    }
                }
                
                //
                if(!isset($shop->title)){
                    $shop->title = $val->shop_title;
                    $shop->map_2gis_url = $val->map_2gis_url;
                    $shop->contacts = $val->contacts;
                    $shop->shop_id = $val->shop_id;
                    $shop->min_price = $val->min_price;
                    $shop->link_whatsapp = $val->link_whatsapp;
                    $shop->main_phone = $val->main_phone;
                    $shop->cost_delivery = $val->cost_delivery;
                    $shop->delivery_methods = collect(unserialize($val->delivery_methods));
                    $shop->payment_methods = collect(unserialize($val->payment_methods));
                    if(Helper::getImg($val->shop_logo, 'logo')){
                        $shop->logo = Helper::getImg($val->shop_logo, 'logo');
                    }
                    $shop->total = 0;
                }
                $shop->total += $priceProduct;
                $shop->products[] = $val;
            }
        }
        
        return $shop;
    }
    
    public function getDistricts(Request $request){
        if($request->ajax()){
            $districts = DistrictsMinPrice::getDistricts($request->shop_id, $request->city_id);
            return response()->json(['districts' => $districts]);
        }
    }
    
    public function getDelivery(Request $request){
        if($request->ajax()){
            $delivery = Delivery::getDelivery($request->district_id, $request->shop_id);
            $delivery->data = unserialize($delivery->data);
            //минимальная цена заказа для данного района
            $districts_min_price = DistrictsMinPrice::getMinPriceForDistrict($request->district_id, $request->shop_id);
            
            $products = Products::getCart(Products::getCartIds(), $request->shop_id);
            $shop = $this->getShopInfo($products, Products::getCookieCart());
            return response()->json([
                'total' => $shop->total,
                'delivery' => $delivery,
                'districts_min_price' => $districts_min_price
            ]);
        }
    }
    
    public function add(Request $request){
        //если таких данных нет, ошибка 404
        /*if($request->$request->city_id 
                and $request->$request->district_id 
                and $request->$request->street
                and $request->$request->phone
                and $request->$request->fio
                and $request->$request->payment_id
                and $request->$request->delivery_id){
            
            return abort(404);
        }*/
        
        $data = $request;
        
        $products = Products::getCart(Products::getCartIds(), $request->id);
        $shop = $this->getShopInfo($products, Products::getCookieCart());
        $delivery = Delivery::getDelivery($request->district_id, $request->id);
        
        if($delivery){
            $delivery->data = unserialize($delivery->data);

            if($delivery->data['free_shipping']['price'] >= $shop->total){
                $data->delivery_price = $delivery->data['rate_shipping']['price'];
            }
            else $data->delivery_price = 0;
        }
        else{
            $data->district_id = null;
            $data->city_id = null;
        }
        
        /*foreach ($products as $key => $val){
            if(!Helper::isDiscount($val->start_discount, $val->end_discount, $val->discount)){
                $val->price = ($val->price - ($val->price / '10%'));
            } 
        }*/
        
        try{
            \DB::beginTransaction();//нало транзакции
            $id = Orders::add($data);
            $result = Order_product::add(Products::getCart(Products::getCartIds(), $data->id), Products::getCookieCart(), $id, $shop->shop_id);
            \DB::commit();//конец транзакции
            
            //удаляем товары из корзины данного магазина
            $remove_products_id = $products->pluck('id');
            $newProducts = collect(Products::getCookieCart())->diffKeys($remove_products_id->flip());
            //toArray
            Products::updateCookieCart($newProducts->values()->toArray());
            
            //отправляем почту
            //$this->sendMailOrder($id);
            
            $array = [
                'nameSite' => config('app.name'),
                'id' => $id,
                'email' => ''
            ];
            
            if(Auth::check()){
                $array['email'] = Auth::user()->email;
            }
            
            $this->dispatch(new SendEmailNewOrder($array));//кидаем отправку письма в очередь
            
            //отправляем смс
            $array = [
                'phone' => $request->phone,
                'id' => $id
            ];
            //$this->dispatch(new SendSmsNewOrder($array));//кидаем отправку смс в очередь
            //$this->sendSms($request->phone, $id);
            return redirect()->route('messages')->with('message-success', 'Ваш заказ успешно сформирован');
            
        }
        catch (\Exception $e){
            //dd($e->getMessage());
            \DB::rollback();//Отмена транзакции и изменений, вызванных её выполнением
            return redirect()->route('messages')->with('message-error', 'Произошла ошибка во время создания заказа');
        }

        
    }
    
    /*private function sendSms($phone, $id){
        $mobizon = new MobizonSend();
        $mobizon->SendSms($phone, config('mobizon.messages.order'). ' Номер заказа - '.str_pad($id, 6, '0', STR_PAD_LEFT).' '.config('app.url'));
    }*/
    
    /*private function sendMailOrder($id){
        $array = [];
        $array['nameSite'] = config('app.name');
        $array['id'] = $id;
        
        if(Auth::check()){
            Mail::send('emails/order', $array, function($message){
                $message->from(config('mail.from.address'));//от кого
                $message->to(Auth::user()->email);//кому отправляем
                $message->subject('Создание заказа');//тема письма
            });
        }
        
        Mail::send('emails/order', $array, function($message){
            $message->from(config('mail.from.address'));//от кого
            $message->to(config('app.contacts.email'));//кому отправляем
            $message->subject('Создание заказа');//тема письма
        });
        
    }*/

}
