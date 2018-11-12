<?php
namespace App\Http\Controllers\Api\v1\Site;

use App\Http\Controllers\Api\v1\RestController;

use Illuminate\Http\Request;

use App\Http\Models\Site\Chars;
use App\Http\Models\Site\CharsProducts;
use App\Http\Models\Site\Products;
use App\Http\Models\Site\Reviews;
use App\Http\Models\Site\ProductCategories;
use App\Http\Models\Site\PaymentMethods;
use App\Http\Models\Site\DeliveryMethods;
use App\Http\Models\Site\DistrictsMinPrice;
use App\Http\Models\Site\Cities;

//use Jenssegers\Date\Date;

use App\Helpers\Helper;

class ProductsController extends RestController {

    public function getAllNovelty() {
        $productsDay = Products::getProductDay();
        if($productsDay->count()){
            $productsDay->each(function ($item, $key) {
                if($item->images){
                    $images = array_diff(explode('|', $item->images), array(''));
                    $newArrImages = [];
                    foreach ($images as $image) {
                        $newArrImages[] = config('app.apiUrl').config('filesystems.products.path').'middle/'.$image;
                    }
                    $item->images = $newArrImages;
                }
            });
        }
        return $this->success($productsDay);
    }
    
    public function getProductsByCategory(Request $request) {
        $chars = Products::getChars($request->category_id);
        
        $filterCharIds = array_filter(explode(',', $request->filterChar));
        $price = array_filter(explode(',', $request->price));

        $products = Products::index($request->category_id, $filterCharIds, $price, false, false, $request->sort);
        if($products){
            foreach ($products as $keyProd => $product) {
                if ($product->images) {
                    $arrImages = array_diff(explode('|', $product->images), array(''));
                    foreach ($arrImages as $keyArr => $image) {
                        $arrImages[$keyArr] = config('app.apiUrl').config('filesystems.products.path').'small/'.$image;
                    }
                    $products[$keyProd]->images = $arrImages;
                }
            }
        }
        $this->data['products'] = $products;

        //$this->data['countProducts'] = Products::index($request->category_id, $filterCharIds, $price, true);

        $this->data['priceMax'] = Products::getMax($request->category_id, false, $filterCharIds);
        $this->data['priceMin'] = Products::getMin($request->category_id, false, $filterCharIds);

        if(count($filterCharIds)){
            foreach($chars as $charName){
                if (!$charName->parent_id) continue;

                $filterCharIdsForCount = collect($filterCharIds);

                if(!is_numeric($filterCharIdsForCount->search($charName->id))){
                    $filterCharIdsForCount->push($charName->id);
                }

                //$charName->productsCount = Products::countProductsChar($filterCharIdsForCount, $price, $request->category_id);

                if(is_numeric(array_search($charName->id, $filterCharIds))){
                    $charName->check = true; //ставим местку того, что данная характеристика была выбрана в фильтре
                }
            }
        }
        //$this->data['currentCategory'] = ProductCategories::getById($request->category_id);
        
        //харкетристики
        $collectChars = collect();
        $collectChars = $collectChars->push(Chars::getParents($chars));
        $collectChars = $collectChars->push($chars);
        //
        
        $this->data['filter'] = $this->buildTree($collectChars->collapse());
        return $this->success($this->data);
    }
    
    public function getById(Request $request){
        Products::incrementViews($request->id);
        
        $product = Products::getById($request->id);
        if($product->images){
            $product->images = explode('|', $product->images);
            $images = [];
            foreach ($product->images as $image) {
                    $images[] = config('app.apiUrl').config('filesystems.products.path').'large/'.$image;
            }
            $product->images = $images;
        }
        $this->data['product'] = $product;
        
        $this->data['reviewsProduct'] = Reviews::getAllReviewsProduct($request->id, 2);
        $this->data['reviewsShop'] = Reviews::getAllReviewsShop($this->data['product']->shop_id, 2);
        $this->data['similarProducts'] = Products::getProductsOtherCategories($this->data['product']);//похожие товары
        $this->data['payment_methods'] = PaymentMethods::getAll();//Способы оплаты
        $this->data['delivery_methods'] = DeliveryMethods::getAll();//Способы доставки
        
        $this->data['product']->payment_methods = collect(unserialize($this->data['product']->payment_methods));
        $this->data['product']->delivery_methods = collect(unserialize($this->data['product']->delivery_methods));
        
        //получаем все отзывы магазина
        $allReviewsShop = Reviews::getAllReviewsShop($this->data['product']->shop_id, 'all');
        $countReviewsShop = count($allReviewsShop);
        $ratingShop = 0;
        $percentRating = 0;
        if($countReviewsShop != 0){
            //узнаем положительное количество отзывов, если рейтинг отзыва больше 3-х тогда рейтинг считается положительным
            $positiveRating = 0;//малый рейтинг
            foreach ($allReviewsShop as $val) {
                $ratingShop += $val->rating;
                if($val->rating > 3){
                    $positiveRating++;
                }
            }
            $percentRating = round(($positiveRating/$countReviewsShop)*100);
            $ratingShop = $ratingShop / $countReviewsShop;
        }
        $this->data['percentRating'] = $percentRating;
        $this->data['countReviewsShop'] = $countReviewsShop;
        $this->data['ratingShop'] = $ratingShop;
        
        //
        $districts = DistrictsMinPrice::getDistricts($this->data['product']->shop_id);
        $cities = Cities::getAll();
        if(isset($cities)){
            foreach($cities as $city){
                $city->child = collect();
                foreach ($districts as $district){
                    if($city->id == $district->city_id){
                        $city->child->push($district);
                    }
                }
            }
        }
        
        $this->data['cities'] = $cities;

        //характеристики
        $charsProducts = CharsProducts::getByProductId($this->data['product']->id);
        $chars = Chars::getParents($charsProducts);
        $charsTmpl = [];
        foreach ($chars as $key => $char) {
			$values = $charsProducts->where('parent_id', $char->id);
			if($values){
				$char->values = $values->implode('title', ', ');
			}
        }
        //

        $this->data['chars'] = $chars;
        $this->data['charsOrder'] = $chars->where('selected_order', 1);//получаем цвет и размеры товара для выборки в заказе
        $this->data['linkWhatsappShop'] = $this->data['product']->link_whatsapp;
        $this->data['mainPhoneShop'] = $this->data['product']->main_phone;
        
        return $this->success($this->data);
    }
    
    

}