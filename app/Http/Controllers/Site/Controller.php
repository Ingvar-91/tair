<?php

namespace App\Http\Controllers\Site;

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

    public $data = [];
    public $categoriesAll; //все категории товаров

    public function __construct() {
        $shops = Shops::getShopsAndCountProduct();
        $this->data['shopsForContacts'] = Shops::getShopsForContacts();
        $shopsEntertainmentPlaces = Shops::getAllEntertainmentPlaces();
        $this->categoriesAll = collect();
        $shops = $shops->merge($shopsEntertainmentPlaces);
        $this->data['shops'] = $shops;

        //$this->getCategories(ProductCategories::index());
        $productCategories = $this->getProductCategories(ProductCategories::index());
        //$this->data['product_categories'] = $this->buildTree($this->categoriesAll->collapse());
        $this->data['product_categories'] = $this->buildTree($productCategories);

        if (count($shopsEntertainmentPlaces)) {
            $entertainment_places = new \StdClass();
            $entertainment_places->title = 'Популярные места';
            $entertainment_places->id = 0;
            $entertainment_places->parent_id = 0;
            $entertainment_places->count = count($shopsEntertainmentPlaces);
            $entertainment_places->child = $shopsEntertainmentPlaces;

            $this->data['product_categories'][] = $entertainment_places;
        }

        $this->data['cartCount'] = Products::getCartCount();
        $this->data['wishlistCount'] = Products::getWishlistCount();
    }

    function getCategories($childs = false) {
        $collect = collect();

        $this->categoriesAll->push($childs);

        $collectCollapse = $this->categoriesAll->collapse();

        $filterParentsId = [];
        $parentsId = [];

        foreach ($childs->pluck('parent_id')->unique() as $id) {
            if (!$collectCollapse->pluck('id')->search($id)) {
                if ($id > 0) {
                    $parentsId[] = $id;
                }
            } else {
                $filterParentsId[] = $id;
            }
        }

        if (count($filterParentsId)) {
            foreach ($filterParentsId as $filterId) {
                $childs->where('parent_id', $filterId);
                if (($this->categoriesAll->last()->where('id', $filterId)->first()) and ( $childs->where('parent_id', $filterId)->first())) {
                    $this->categoriesAll->last()->where('id', $filterId)->first()->count += $childs->where('parent_id', $filterId)->first()->count;
                }
            }
        }

        if (count($parentsId)) {
            $parents = ProductCategories::getByIdIn($parentsId);
            foreach ($parents as $parent) {
                $parent->count = $collectCollapse->where('parent_id', $parent->id)->pluck('count')->sum();
            }

            $this->getCategories($parents);
        }
    }

    //
    function buildTree($elements, $parentId = 0, $nameVariable = 'parent_id') {
        $branch = array();

        foreach ($elements as $element) {
            if ($element->$nameVariable == $parentId) {
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
        foreach ($array as $key => $val) {
            $arrayNew[$val->$nameKey] = $val;
        }
        return $arrayNew;
    }

    //
    protected function getFieldsDataTables($request) {
        $fields['limit'] = $request->input('length');
        $fields['offset'] = $request->input('start');
        $fields['columns'] = $request->input('columns');
        $fields['order'] = $request->input('order');
        $fields['order'] = array_shift($fields['order']);
        $fields['nameColumn'] = $fields['columns'][$fields['order']['column']]['data']; // зная номер колонки, получаем её название
        $fields['dirOrder'] = $fields['order']['dir']; // order ASK/DESK
        $fields['searchValue'] = $request->input('search')['value'];
        $fields['shop_id'] = $request->input('shop_id');
        return $fields;
    }
    
    /*рекурсивно получить родителей категорий и количество к ним */
    protected function getProductCategories($childs, $categories = false) {
        if(!$categories){
            $categories = collect();
            $categories->push($childs);
        }
        
        $parents_id = $childs->pluck('parent_id')->unique();
        if(count($parents_id)){
            $parentsCategories = ProductCategories::getByIdIn($parents_id);
            if($parentsCategories->count()) {    
                $allCategoriesId = $categories->collapse()->pluck('id')->unique();
                $parentCategoriesId = $parentsCategories->pluck('id')->unique();
                $intersect = $allCategoriesId->intersect($parentCategoriesId);
                $parents = $parentsCategories->whereNotIn('id', $intersect);
                
                $this->getProductCategories($parentsCategories, $categories->push($parents));
            }
        }
        $categories = $categories->collapse();
        
        /**/
        $keys = [];
        foreach ($categories->whereNotIn('count', 0) as $item) {
            if (!isset($keys[$item->parent_id])) {
                $keys[$item->parent_id] = 0;
            }
            $keys[$item->parent_id] += $item->count;
        }
        /**/
        
        $categories = $this->getProductCategoriesCount($keys, $categories);
        
        return $categories;
    }
    
    protected function getProductCategoriesCount($keys, $categories){
        foreach ($keys as $parent_id => $count) {
            $parent = $categories->where('id', $parent_id)->first();
            if($parent){
                if(isset($parent->count)) {
                    $parent->count = 0;
                }
                $parent->count += $count;
            } 
        }
        return $categories;
    }

}
