<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Site\Controller;

use Illuminate\Http\Request;

use App\Http\Models\Site\ProductCategories;

class CategoriesController extends Controller {

    const tmpl = 'site/categories/';
    
    private $product_categories = [];
    
    public function index(Request $request){
        $categories = ProductCategories::getById($request->id)->children()->get();
        if(!$categories->count()){
            return redirect('/products/'.$request->id);
        }
        $this->data['breadcrumb'] = $this->getParentsCategory($request->id, collect())->reverse()->push(ProductCategories::getById($request->id));
        $this->data['categories'] = $categories;
        return view(self::tmpl.'index', $this->data);
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

}
