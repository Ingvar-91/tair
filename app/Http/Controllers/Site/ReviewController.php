<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Site\Controller;
use Illuminate\Http\Request;

use App\Http\Models\Site\Products;
use App\Http\Models\Site\Shops;
use App\Http\Models\Site\Reviews;
use App\Http\Models\Site\Order_product;

use Auth;

class ReviewController extends Controller {

    const tmpl = 'site/reviews/';
    
    public function addReviewProduct(Request $request){
        if ($request->ajax()) {
            if(Auth::check()){
                //юзер уже оставлял отзыв
                if(Reviews::userReviewProductExist(Auth::user()->id, $request->product_id)){
                    return response()->json(['status' => 3]);
                }
                
                //юзер покупал данный товар
                /*if(!Order_product::userOrderProductExist(Auth::user()->id, $request->product_id)){
                    return response()->json(['status' => 2]);
                }*/
                
                $addReview = Reviews::addReviewProduct($request, 1);
                
                if($addReview){
                    //получить отзывы товара
                    $reviews = Reviews::getAllReviewsProduct($request->product_id, 'all');

                    //рачитать общий рейтинг
                    $rating = 0;
                    $countReviews = count($reviews);
                    if($reviews){
                        foreach ($reviews as $review) {
                            $rating += $review->rating;
                        }
                    }
                    $rating = $rating / $countReviews;
                    
                    //обновить в товаре данные по рейтингу и количестве отзывов
                    Products::updateRating($request->product_id, $rating, $countReviews);
                    //
                    return response()->json(['status' => $addReview]);
                }
            }
        }
    }
    
    public function addReviewShop(Request $request){
        if ($request->ajax()) {
            if(Auth::check()){
                //юзер покупал какой-нибудь товар в этом магазине
                /*if(!Order_product::userOrderShopExist(Auth::user()->id, $request->shop_id)){
                    return response()->json(['status' => 2]);
                }*/
                
                //юзер уже оставлял отзыв
                if(Reviews::userReviewShopExist(Auth::user()->id, $request->shop_id)){
                    return response()->json(['status' => 3]);
                }
                
                return response()->json(['status' => Reviews::addReviewShop($request, 2)]);
            }
        }
    }
    
    public function getAllReviewsProduct(Request $request){
        $this->data['product'] = Products::getById($request->id);
        $this->data['reviews'] = Reviews::getAllReviewsProduct($request->id);
        return view(self::tmpl . 'reviews-product', $this->data);
    }
    
    public function getAllReviewsShop(Request $request){
        $this->data['shop'] = Shops::getById($request->id);
        $this->data['reviews'] = Reviews::getAllReviewsShop($request->id);
        return view(self::tmpl . 'reviews-shop', $this->data);
    }
}
