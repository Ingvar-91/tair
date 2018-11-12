<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Site\Controller;
use Illuminate\Http\Request;

use App\Http\Models\Site\Chars;
use App\Http\Models\Site\CharsProducts;
use App\Http\Models\Site\ProductCategories;

use Redirect;

class CharsController extends Controller {
    
    const tmpl = 'site/chars/';
    
    private $categoriesId;
    
    public function __construct(){
        parent::__construct();
        
        $this->categoriesId = collect();
    }
    
    public function index(Request $request){
        //получить все id родителей, вплоть до самого первого
        $this->getCategoriesId($request->category_id);
        
        if($request->ajax()){
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
            return response()->json(['chars' => $chars]);
        }
        
        /*$this->data['category'] = ProductCategories::getById($request->category_id);
        
        $chars = collect([Chars::index($request), Chars::getByCategoryIdIn($this->categoriesId)]);
        $chars = $chars->collapse();
        $this->data['chars'] = $this->buildTree($chars);
        return view(self::tmpl.'index', $this->data);*/
    }
    
    private function getCategoriesId($category_id = false){
        $category = ProductCategories::getById($category_id);
        if($category->parent_id){
            $this->categoriesId->push($category->parent_id);
            $this->getCategoriesId($category->parent_id);
        }
    }

}