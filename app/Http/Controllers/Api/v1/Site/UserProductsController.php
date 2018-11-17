<?php

namespace App\Http\Controllers\Api\v1\Site;

use App\Http\Controllers\Api\v1\RestController;
use Illuminate\Http\Request;
use Auth;
use App\Files\UploadImages;
use App\Helpers\Helper;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Models\Site\Products;
use App\Http\Models\Site\ProductCategories;
use App\Http\Models\Site\Chars;

use Illuminate\Support\Facades\Cache;

class UserProductsController extends RestController {

    use UploadImages;
    
    private $categoriesId;
    
    public function __construct(){
        parent::__construct();
        
        $this->categoriesId = collect();
    }

    public function getUserProducts(Request $request): Response {
        $products = Products::getUserProducts($request);
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
        $products = $products->items();
        return $this->success($products);
    }
    
    public function getUserProduct(Request $request): Response {
        $product = Products::getUserProduct($request->product_id);
        
        $minutes = 525600;// 1 год
        $categories = Cache::remember(config('cache.member.categories.api_products'), $minutes, function () {
            $categories = ProductCategories::getAll();
            if($categories){
                foreach ($categories as $key => $category) {
                    if($category->image){
                        $category->image = config('app.apiUrl').config('filesystems.categories.path').$category->image;
                    }
                }
            }
            return $this->buildTree($categories);
        });
        
        $this->data['categories'] = $categories;
        $this->data['product'] = $product;
        return $this->success($this->data);
    }
    
    public function getCharsProduct(Request $request): Response {
        $this->getCategoriesId($request->category_id);
        
        $chars = collect([Chars::index($request), Chars::getByCategoryIdIn($this->categoriesId)]);
        $chars = $chars->collapse();
        if($request->product_id){
            $charsProducts = CharsProducts::getByProductId($request->product_id);
            foreach($chars as $char){
                if($char->parent_id == 0) continue;
                $check = $charsProducts->where('char_id', $char->id)->count();
                if($check){
                    $char->check = true;
                }
            } 
        }
        $chars = $this->buildTree($chars);
        
        return $this->success($chars);
    }

    private function getCategoriesId($category_id = false){
        $category = ProductCategories::getById($category_id);
        if($category->parent_id){
            $this->categoriesId->push($category->parent_id);
            $this->getCategoriesId($category->parent_id);
        }
    }

}
