<?php

namespace App\Http\Controllers\Api\v1\Site;

use App\Http\Controllers\Api\v1\RestController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Models\Site\Shops;
use App\Http\Models\Site\Products;
use App\Http\Models\Site\ProductCategories;

class ShopsController extends RestController {

    public function getAllEntPlaces(): Response {
        $entertainmentPlaces = Shops::getAllEntertainmentPlaces();
        if($entertainmentPlaces->count()){
            $entertainmentPlaces->each(function ($item, $key) {
                if($item->preview_frontpage){
                    $item->preview_frontpage = config('app.apiUrl').config('filesystems.preview_frontpage.path').$item->preview_frontpage;
                }
            });
        }
        return $this->success($entertainmentPlaces);
    }
    
    public function getShopTop(): Response {
        $shopsTop = Shops::getTopShops();
        if($shopsTop->count()){
            $shopsTop->each(function ($item, $key) {
                if($item->preview_frontpage){
                    $item->preview_frontpage = config('app.apiUrl').config('filesystems.preview_frontpage.path').$item->preview_frontpage;
                }
            });
        }
        return $this->success($shopsTop);
    }
    
    public function getAll(): Response {
        $shops = Shops::getShopsAndCountProduct();
        if($shops){
            foreach ($shops as $shop) {
                if($shop->preview_frontpage){
                    $shop->preview_frontpage = config('app.apiUrl').config('filesystems.preview_frontpage.path').$shop->preview_frontpage;
                }
            }
        }
        
        $shopsEntertainmentPlaces = Shops::getAllEntertainmentPlaces();
        if($shopsEntertainmentPlaces){
            foreach ($shopsEntertainmentPlaces as $item) {
                if($item->preview_frontpage){
                    $item->preview_frontpage = config('app.apiUrl').config('filesystems.preview_frontpage.path').$item->preview_frontpage;
                }
            }
        }
        $shops = $shops->merge($shopsEntertainmentPlaces);        
        return $this->success($shops);
    }

    public function getById(Request $request): Response {
        $shop = Shops::getById($request->id);
        if($shop->count()){
            $galleryArr = array_diff(explode('|', $shop->gallery), array(''));
            $galleryNewArr = [];
            foreach ($galleryArr as $keyGalleryImg => $galleryImage) {
                $galleryNewArr[$keyGalleryImg] = config('app.apiUrl').config('filesystems.shops_gallery.path').'large/'.$galleryImage;
            }
            $shop->gallery = $galleryNewArr;
            
            $arrImages = array_diff(explode('|', $shop->images), array(''));
            foreach ($arrImages as $keyArr => $image) {
                $arrImages[$keyArr] = config('app.apiUrl').config('filesystems.shops.path').'large/'.$image;
            }
            $shop->images = $arrImages;
            if($shop->preview_frontpage){
                $shop->preview_frontpage = config('app.apiUrl').config('filesystems.preview_frontpage.path').$shop->preview_frontpage;
            }
        }
        return $this->success($shop);
    }

    public function getProducts(Request $request) {
        $shop = Shops::getById($request->id);

        $filterCharIds = array_filter(explode(',', $request->filterChar));
        $price = array_filter(explode(',', $request->price)); // min,max

        $products = Products::index($request->category_id, $filterCharIds, $price, false, $request->id, $request->sort);
        foreach ($products as $keyProd => $product) {
            if ($product->images) {
                $arrImages = array_diff(explode('|', $product->images), array(''));
                foreach ($arrImages as $keyArr => $image) {
                    $arrImages[$keyArr] = config('app.apiUrl').config('filesystems.products.path').'small/'.$image;
                }
                $products[$keyProd]->images = $arrImages;
            }
        }
        
        $this->data['products'] = $products;
        
        $this->data['countProducts'] = Products::index(false, $filterCharIds, $price, true, $request->id);

        //
        $this->data['priceMax'] = Products::getMax(false, $request->id);
        $this->data['priceMin'] = Products::getMin(false, $request->id);

        $this->data['linkWhatsappShop'] = $shop->link_whatsapp;
        $this->data['mainPhoneShop'] = $shop->main_phone;
        return $this->success($this->data);
    }

}
