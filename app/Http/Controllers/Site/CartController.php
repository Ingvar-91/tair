<?php
namespace App\Http\Controllers\Site;

use App\Http\Controllers\Site\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Site\Products;

use App\Helpers\Helper;

class CartController extends Controller{

    const tmpl = 'site/cart/';

    public function index(Request $request){
        if ($request->ajax()) {
            $products = Products::getCart(Products::getCartIds());
            $cookieCart = Products::getCookieCart();
            
            //вычисляем общую стоимость
            $totalCost = 0;
            $productsShops = [];
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
                        
                    }
                    else{
                        
                    }
                    
                    //
                    $priceProduct = 0;
                    
                    if($val->del == 1){// если товар не удален
                        if(Helper::isDiscount($val->start_discount, $val->end_discount, $val->discount)){
                            $val->oldPrice = $val->price;//старая цена, сюды будет записываться старая цена товара, если есть скидка
                            $val->price = $val->discount;//и вписываем в переменную price цену скидки, дабы в шаблоне не плодить кучу условий

                            $priceProduct = $cookieCart[$val->id]->count * $val->discount;
                            $totalCost += $priceProduct;
                        }
                        else{
                            if($val->price){
                                $priceProduct = $cookieCart[$val->id]->count * $val->price;
                                $totalCost += $priceProduct;
                            }
                        }
                    }

                    //раскидываем товар по магазинам
                    if(!isset($productsShops[$val->shop_id])){
                        $productsShops[$val->shop_id] = new \stdClass();
                        $productsShops[$val->shop_id]->title = $val->shop_title;
                        $productsShops[$val->shop_id]->shop_id = $val->shop_id;
                        
                        if(Helper::getImg($val->shop_logo, 'logo')){
                            $productsShops[$val->shop_id]->logo = Helper::getImg($val->shop_logo, 'logo');
                        }
                        
                        $productsShops[$val->shop_id]->min_price = $val->min_price;
                        $productsShops[$val->shop_id]->total = 0;
                    }
                    $productsShops[$val->shop_id]->total += $priceProduct;
                    $productsShops[$val->shop_id]->products[] = $val;
                }
            }
            
            return response()->json([
                'productsShops' => $productsShops,
                'cookieCart' => $cookieCart,
                'totalCost' => $totalCost,
                'exist' => count($productsShops)
            ]);
        }
    }

}
