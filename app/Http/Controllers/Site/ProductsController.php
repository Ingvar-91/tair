<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Site\Controller;

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

class ProductsController extends Controller {

    const tmpl = 'site/products/';

    public function index(Request $request) {
        $dataAjax = [];
        //$charsName = CharacteristicsName::getByCatetegoryId($request);
        $chars = Products::getChars($request->category_id);
        
        if ($request->ajax()) {
            
            $filterCharIds = $request->filterChar;
            $price = $request->price;
            
            $dataAjax['countProducts'] = Products::index($request->category_id, $filterCharIds, $price, true);
            
            $countChars = [];
            foreach($chars as $charName){
                if (!$charName->parent_id) continue;
                
                $filterCharIdsForCount = collect($filterCharIds);
                if(!is_numeric($filterCharIdsForCount->search($charName->id))){
                    $filterCharIdsForCount->push($charName->id);
                }
                
                $countChars[] = [
                    'id' => $charName->id,
                    'countProduct' => Products::countProductsChar($filterCharIdsForCount, $price, $request->category_id)
                ];
            }
            $dataAjax['countChars'] = $countChars;
            return response()->json($dataAjax);
        }
        else{
            $filterCharIds = array_filter(explode(',', $request->filterChar));
            $price = array_filter(explode(',', $request->price));
            
            $this->data['products'] = Products::index($request->category_id, $filterCharIds, $price, false, false, $request->sort);
            $this->data['countProducts'] = Products::index($request->category_id, $filterCharIds, $price, true);
            
            $this->data['priceMax'] = Products::getMax($request->category_id, false, $filterCharIds);
            $this->data['priceMin'] = Products::getMin($request->category_id, false, $filterCharIds);
            
            if(count($filterCharIds)){
                foreach($chars as $charName){
                    if (!$charName->parent_id) continue;

                    $filterCharIdsForCount = collect($filterCharIds);

                    /*foreach ($filterCharIds as $key => $filterId) {
                        $filter = $charsName->where('id', $filterId)->first();
                        if($filter->parent_id == $charName->parent_id){
                            //if(!is_numeric($filterCharIdsForCount->search($charName->id))){

                            //}
                            $filterCharIdsForCount->forget($key);
                        }
                    }*/

                    if(!is_numeric($filterCharIdsForCount->search($charName->id))){
                        $filterCharIdsForCount->push($charName->id);
                    }
                    
                    $charName->productsCount = Products::countProductsChar($filterCharIdsForCount, $price, $request->category_id);

                    if(is_numeric(array_search($charName->id, $filterCharIds))){
                        $charName->check = true; //ставим местку того, что данная характеристика была выбрана в фильтре
                    }
                }
            }
        }
        
        $this->data['currentCategory'] = ProductCategories::getById($request->category_id);
        $this->data['breadcrumb'] = $this->getParentsCategory($request->category_id, collect())->reverse()->push($this->data['currentCategory']);
        
        //харкетристики
        $collectChars = collect();
        $collectChars = $collectChars->push(Chars::getParents($chars));
        $collectChars = $collectChars->push($chars);
        //
        
        $this->data['chars'] = $this->buildTree($collectChars->collapse());
        
        return view(self::tmpl . 'index', $this->data);
    }
    
    private function getParentsCategory($id, $collect){
        $categories = ProductCategories::getById($id)->parent()->first();
        if($categories){
            $collect->push($categories);
            if($categories->parent_id){
                $this->getParentsCategory($categories->id, $collect);
            }
        }
        
        return $collect;
    }
    
    private function getProductsId($childs, $product_categories) {
        $categories_id = [];
        foreach ($childs as $key => $child) {
            $searchChild = $product_categories->where('parent_id', $child->id);
            if(count($searchChild)){
                $categories_id = array_merge($categories_id, $this->getProductsId($searchChild, $product_categories));
            }
            else{
                $categories_id[] = $child->id;
            }
        }
        return $categories_id;
    }
    
    function buildDepend($elements, $dependId = 0){
        $branch = [];

        foreach ($elements as $element){
            if ($element->depend_id == $dependId) {
                $depend = $this->buildDepend($elements, $element->id);
                if ($depend) {
                    $element->depend = $depend;
                }
                $branch[] = $element;
            }
        }
        return $branch;
    }
    
    public function product(Request $request){
        Products::incrementViews($request->id);
        
        $this->data['product'] = Products::getById($request->id);
        if($this->data['product']->images){
           $this->data['product']->images = explode('|', $this->data['product']->images);
        }
        
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
        foreach($cities as $city){
            $city->child = collect();
            foreach ($districts as $district){
                if($city->id == $district->city_id){
                    $city->child->push($district);
                }
            }
        }
        $this->data['cities'] = $cities;

        //характеристики
        $charsProducts = CharsProducts::getByProductId($this->data['product']->id);
        $chars = Chars::getParents($charsProducts);
        $charsTmpl = [];
        foreach ($chars as $key => $char) {
            $char->values = $charsProducts->where('parent_id', $char->id);
        }
        //

        $this->data['chars'] = $chars;
        $this->data['charsOrder'] = $chars->where('selected_order', 1);//получаем цвет и размеры товара для выборки в заказе
        $this->data['linkWhatsappShop'] = $this->data['product']->link_whatsapp;
        $this->data['mainPhoneShop'] = $this->data['product']->main_phone;
        
        $this->data['breadcrumb'] = $this->getParentsCategory($this->data['product']->category_id, collect())->reverse()->push(ProductCategories::getById($this->data['product']->category_id));
        return view(self::tmpl . 'product', $this->data);
    }
    
    

}