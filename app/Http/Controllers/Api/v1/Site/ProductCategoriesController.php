<?php

namespace App\Http\Controllers\Api\v1\Site;

use App\Http\Controllers\Api\v1\RestController;

use Illuminate\Http\Request;

use App\Http\Models\Site\ProductCategories;

class ProductCategoriesController extends RestController {
    
    private $categoriesAll;
    
    public function getById(Request $request) {
        $data = ProductCategories::getById($request->id);
        return $this->success($data);
    }
	
    public function getAll(){
        $data = [];
        $categories = ProductCategories::index();
        if($categories){
            foreach ($categories as $key => $category) {
                if($category->image){
                    $category->image = config('app.apiUrl').config('filesystems.categories.path').$category->image;
                }
            }
            $this->categoriesAll = collect();
            $this->getCategories($categories);
            $data = $this->buildTree($this->categoriesAll->collapse());
        }
        return $this->success($data);
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
                if($parent->image){
                    $parent->image = config('app.apiUrl').config('filesystems.categories.path').$parent->image;
                }
                $parent->count = $collectCollapse->where('parent_id', $parent->id)->pluck('count')->sum();
            }

            $this->getCategories($parents);
        }
    }
    
}
