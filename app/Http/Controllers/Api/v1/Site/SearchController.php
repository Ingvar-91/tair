<?php

namespace App\Http\Controllers\Api\v1\Site;

use App\Http\Controllers\Api\v1\RestController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Models\Site\Products;

use vladkolodka\phpMorphy\Morphy;
use JanDrda\LaravelGoogleCustomSearchEngine\LaravelGoogleCustomSearchEngine;

class SearchController extends RestController {

    public function search(Request $request): Response {
        $morphy = new Morphy('ru');
        $searchArrayWord = explode(' ', trim($request->text));
        $arrayWord = collect();
        foreach ($searchArrayWord as $i => $word) {
            $arrayWord->push( collect($morphy->getPseudoRoot(mb_strtoupper($word, 'UTF-8'))) );
        }
        $products = Products::search($arrayWord->collapse());
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
        
        return $this->success($products);
    }
    

}
