<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Http\Models\Site\Products;
use App\Http\Models\Site\Shops;
use App\Http\Models\Site\ProductCategories;

class Controller extends BaseController {

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    protected $data = [];
    
    public function __construct(){
        $this->data['shops'] = Shops::getAll();
        $this->data['product_categories'] = $this->buildTree(ProductCategories::index());
        $this->data['cartCount'] = Products::getCartCount();
        $this->data['wishlistCount'] = Products::getWishlistCount();
    }
    
    function buildTree($elements, $parentId = 0) {
        $branch = array();

        foreach ($elements as $element) {
            if ($element->parent_id == $parentId) {
                $children = $this->buildTree($elements, $element->id);
                if ($children) {
                    $element->child = $children;
                }
                $branch[] = $element;
            }
        }
        return $branch;
    }
	
    protected function collectArray($array, $nameKey) {
        $arrayNew = [];
        foreach($array as $key => $val){
            $arrayNew[$val->$nameKey] = $val;
        }
        return $arrayNew;
    }

}
