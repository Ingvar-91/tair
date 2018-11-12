<?php

namespace App\Helpers;

use App\Http\Models\Site\Products;
use Storage;

class Helper {
    
    //есть ли товар в скписке желаемого
    public static function isWishlist($id){
        $ids = Products::getWishlistIds();
        return self::arraySearch($id, $ids);
    }
    
    /*
    //есть ли в листе сравнения товаров
    public static function isCompare($id){
        $ids = Products::getCompareIds();
        return self::arraySearch($id, $ids);
    }
    */
    
    public static function phoneMobileFormat($phone) {
        return "+7 (".substr($phone, 1, 3).") ".substr($phone, 4, 3)."-".substr($phone, 7, 2)."-".substr($phone, 9);
    }
    
    public static function wordForms($num, $titles){
        $cases = [2, 0, 1, 1, 1, 2];
        return $num . ' ' . $titles[($num % 100 > 4 && $num % 100 < 20) ? 2 : $cases[min($num % 10, 5)]];
    }
    
    //есть ли товар в корзине
    public static function isCart($id){
        $ids = Products::getCartIds();
        return self::arraySearch($id, $ids);
    }
    
    private static function arraySearch($id, $ids){
        if(is_numeric(array_search($id, $ids))){
            return true;
        }
        return false;
    }
    
    //получить первое изображение
    /*public static function getFirstImg($images, $name){
        return '/'.config('filesystems.'.$name.'.path').'small/'.explode('|', $images)[0];
    }*/
    
    //получить изображение
    public static function getImg($images, $name, $size = false){
        if(!$images) return false;
        $images = array_diff(explode('|', $images), ['']);
        if(count($images) < 2){
            $images = $images[0];
        }
        
        if(is_array($images)){
            $pathImg = '/'.config('filesystems.'.$name.'.path').$size.'/'.$images[0];
        }
        else{
            if(!$size){
                $pathImg = '/'.config('filesystems.'.$name.'.path').$images;
            }
            else $pathImg = '/'.config('filesystems.'.$name.'.path').$size.'/'.$images;
        }
        
        if(Storage::exists($pathImg)){
            return $pathImg;
        }
        else{
            return false;
        }
    }
    
    //является ли товар новинкой
    public static function isNew($date) {
        $now = date('Y-m-d', strtotime('-7 day', time()));
        if($date > $now) return true;
        else return false;
    }
    
    //истекло ли время скидки
    public static function isDiscount($start_discount, $end_discount, $discount) {
        if(!$discount) return false;
        $now = date('Y-m-d H:i:s', time());
        
        if($start_discount <= $now){//если скидка началась
            if($end_discount > $now) return true;//если не окончалась, тогда true
        }
        else return false;
    }
    
    //получаем процент скидки
    public static function getDiscountPercent($price, $discount) {
        return round(100 - ($discount/($price/100)));
    }
    
    //получить абзац текста
    public static function indent($text) {
        $indent = '';
        $arrayP = preg_split('/<p>/', $text, null, PREG_SPLIT_NO_EMPTY);
        foreach ($arrayP as $key => $value) {
            preg_match_all('#<img.*src="(.*)".*>#isU', $value, $matches);
            if(!isset($matches[0][0])){//если изображение отсутствует в абзаце
                $indent = '<p>'.$value;
                break;
            }
        }
        return $indent;
    }
    
    //имя страницы/роутера на которой находимся
    public static function getPageName($request){
        if(!$request->page) return explode('/', $request->getPathInfo())[2];
        else return $request->page;
    }
}