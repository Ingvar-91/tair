<?php

namespace App\Http\Controllers\Api\v1\Site;

use App\Http\Controllers\Api\v1\RestController;
use App\Http\Models\Site\Products;
use App\Http\Models\Site\Slider;
use App\Http\Models\Site\Shops;
use App\Http\Models\Site\Brands;

class HomeController extends RestController {
    
    public function getAllBrands() {
        $brands = Brands::getAll()->first();
        if ($brands) {
            $brandsImages = array_diff(explode('|', $brands->images), ['']);
            if(count($brandsImages)){
                foreach($brandsImages as $key => $brandImage) {
                    $brandsImages[$key] = config('app.apiUrl').config('filesystems.logo_brands.path').'large/'.$brandImage;
                }
                $data = $brandsImages;
            }
        }
        return $this->success($data);
    }

    public function index() {
        $productsDay = Products::getProductDay(6);
        if($productsDay->count()){
            $productsDay->each(function ($item, $key) {
                if($item->images){
                    $images = array_diff(explode('|', $item->images), []);
                    $newArrImages = [];
                    foreach ($images as $image) {
                        $newArrImages[] = config('app.apiUrl').config('filesystems.products.path').'middle/'.$image;
                    }
                    $item->images = $newArrImages;
                }
            });
        }
        $this->data['productsDay'] = $productsDay;
        /**/
        $shopsTop = Shops::getTopShops(6);
        if($shopsTop->count()){
            $shopsTop->each(function ($item, $key) {
                if($item->preview_frontpage){
                    $item->preview_frontpage = config('app.apiUrl').config('filesystems.preview_frontpage.path').$item->preview_frontpage;
                }
            });
        }
        $this->data['shopsTop'] = $shopsTop;
        /**/
        $entertainmentPlaces = Shops::getAllEntertainmentPlaces(6);
        if($entertainmentPlaces->count()){
            $entertainmentPlaces->each(function ($item, $key) {
                if($item->preview_frontpage){
                    $item->preview_frontpage = config('app.apiUrl').config('filesystems.preview_frontpage.path').$item->preview_frontpage;
                }
            });
        }
        $this->data['entertainmentPlaces'] = $entertainmentPlaces;
        /**/
        $this->data['slider'] = [];
        $slider = Slider::getAll()->first();
        if ($slider) {
            $sliderImages = array_diff(explode('|', $slider->images), ['']);
            if(count($sliderImages)){
                foreach($sliderImages as $keySliderImage => $sliderImage) {
                    $sliderImages[$keySliderImage] = config('app.apiUrl').config('filesystems.slider.path').'large/'.$sliderImage;
                }
                $this->data['slider'] = $sliderImages;
            }
        }
        /**/
        $this->data['brands'] = [];
        $brands = Brands::getAll()->first();
        if ($brands) {
            $brandsImages = array_diff(explode('|', $brands->images), ['']);
            $brandsImages = array_splice($brandsImages, 0, 8);
            if(count($brandsImages)){
                foreach($brandsImages as $key => $brandImage) {
                    $brandsImages[$key] = config('app.apiUrl').config('filesystems.logo_brands.path').'large/'.$brandImage;
                }
                $this->data['brands'] = $brandsImages;
            }
        }
        /**/
        return $this->success($this->data);
    }

}
