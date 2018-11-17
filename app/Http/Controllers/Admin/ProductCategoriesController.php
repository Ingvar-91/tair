<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Admin\ProductCategories;
use Auth;
use Illuminate\Support\Facades\Cache;

use App\Files\UploadImage;

class ProductCategoriesController extends Controller {
    
    use UploadImage;
    
    const tmpl = 'admin/product_categories/';
    
    public function index(Request $request){
        if ($request->ajax()) {
            $categories = Cache::remember(config('cache.member.categories.admin_products'), 525600, function () {
                return $this->buildTree(ProductCategories::index());
            });
            return response()->json(['error' => empty($categories), 'categories' => $categories]);
        }
        
        $this->data['categories'] = Cache::remember(config('cache.member.categories.admin_products'), 525600, function () {
            return $this->buildTree(ProductCategories::index());
        });
        return view(self::tmpl.'index', $this->data);
    }
    
    public function edit(Request $request){
        if ($request->ajax()){
            $category = ProductCategories::getById($request->id);
            
            $nameImage = $category->image;
            if($request->hasFile('image')){
                $nameImage = $this->uploadImage($request->file('image'), 'categories');
                if($nameImage) $this->removeImage($category->image, 'categories');
            }
            
            return response()->json(['error' => empty(ProductCategories::edit($request, $nameImage))]);
        }
    }
    
    public function add(Request $request){
        if ($request->ajax()) {
            return response()->json(['error' => empty(ProductCategories::add($request))]);
        }
    }
    
    public function remove(Request $request){
        if ($request->ajax()) {
            return response()->json(['error' => empty(ProductCategories::remove($request))]);
        }
    }
    
    public function getCategory(Request $request){
        if ($request->ajax()) {
            $categories = $this->buildTree(ProductCategories::index($request));
            $category = ProductCategories::getById($request->id); 
            if((empty($categories) == false) && (empty($category) == false)){
                return response()->json(['error' => false, 'categories' => $categories, 'category' => $category]);
            }
            else return response()->json(['error' => true]);
        }
    }
}
