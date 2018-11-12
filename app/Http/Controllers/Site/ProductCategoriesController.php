<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Site\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Site\ProductCategories;
use Auth;

class ProductCategoriesController extends Controller {
    
    public function index(Request $request){
        if ($request->ajax()) {
            $categories = $this->buildTree(ProductCategories::getAll());
            return response()->json(['error' => empty($categories), 'categories' => $categories]);
        } 
    }
    
    public function edit(Request $request){
        if ($request->ajax()){
            return response()->json(['error' => empty(ProductCategories::edit($request))]);
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
            $categories = $this->buildTree(ProductCategories::getAll());
            $category = ProductCategories::getById($request->id); 
            if((empty($categories) == false) && (empty($category) == false)){
                return response()->json(['error' => false, 'categories' => $categories, 'category' => $category]);
            }
            else return response()->json(['error' => true]);
        }
    }
    
}
