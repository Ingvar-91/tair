<?php

namespace App\Http\Models\Site;

use Illuminate\Database\Eloquent\Model;

use App\Http\Models\Site\Reviews;
use DB;
use Auth;

class Products extends Model{
    
    //получить данные для DateTables
    public static function getDataForDataTables($fields){
        $query = Products::orderBy($fields['nameColumn'], $fields['dirOrder'])
                ->leftJoin('users', 'products.user_id', '=', 'users.id')
                ->addSelect(
                    'products.*',
                    'users.email',
                    'users.name'
                )
                ->leftJoin('shops', 'products.shop_id', '=', 'shops.id')
                ->addSelect(
                    'shops.title as shops_title'
                );
        
        self::queryWhere($query, $fields);
        
        if($fields['searchValue']){//если задана строка поиска
            $columns = $fields['columns'];
            $searchValue = $fields['searchValue'];
            $query->Where(function ($query) use ($columns, $searchValue) {
                $arrayWord = explode(' ', trim($searchValue));
                foreach ($arrayWord as $value) {
                    $query->orWhere('users.name', 'like', '%'.$value.'%');
                    $query->orWhere('users.email', 'like', '%'.$value.'%');
                    $query->orWhere('products.title', 'like', '%'.$value.'%');
                    $query->orWhere('products.text', 'like', '%'.$value.'%');
                    $query->orWhere('shops.title', 'like', '%'.$value.'%');
                }
            });
            return $query->get();
        }
        else return $query->limit($fields['limit'])->offset($fields['offset'])->get();
    }
    
    public static function queryWhere($query = false, $fields = false){
        if(!$query) $query = Products::orderBy('id', 'desk');
        
        //$query->where('products.shop_type_id', '=', $shop_type);
        $query->where('products.shop_id', $fields['shop_id'])
        ->where('products.date_remove', '>', date('Y-m-d H:i:s'))
        ->where('products.del', '=', 1);
        //->whereIn('products.status', 2);
        
        return $query;
    }
    
    //обновить рейтинг товара и количество отзывов
    public static function updateRating($product_id, $rating, $countReviews){
        return Products::where('id', $product_id)->update([
            'rating' => $rating,
            'countReviews' => $countReviews
        ]);
    }
    
    public static function incrementViews($id){
        return Products::where('id', '=', $id)->increment('views', 1);
    }
    
    public static function getProductDay($limit = 6){
        return Products::where('products.del', 1)
                ->where('products.status', 2)
                ->where('products.shop_type_id', 1)
                ->where('shops.status', 2)
                ->where('products.date_remove', '>', date('Y-m-d H:i:s'))
                ->leftJoin('shops', 'products.shop_id', '=', 'shops.id')
                ->addSelect(
                    'products.*',
                    'shops.title as shop_title',
                    'shops.placeholder as shop_placeholder',
                    'shops.phone_numbers'
                )
                ->orderBy('products.views', 'desc')
                ->when($limit, function ($query, $limit) {
                    return $query->limit($limit);
                })
                ->get();
    }
    
    public static function getNewProduct(){
        /* Внимание, здесь говнокод! */
        $shops_id = collect([]);
        for ($i = 0; $i < 100; $i++){
            $product = self::getLastProduct($shops_id);
            if (!$product) {
                break;
            }
            $shops_id->push($product->pluck('shop_id')->unique()->first());
            if (count($shops_id) == 4) {
                break;
            }
        }
        
        $shops_id = $shops_id->filter(function ($value, $key) {
            if ($value) {
                return $value;
            }
        });
        
        $data = collect([]);
        if ($shops_id) {
            foreach ($shops_id as $shop_id) {
                $data->push(self::getLastProductByShopId($shop_id));
            }
            $data = $data->collapse();
        }
        return $data;
    }
    
    private static function getLastProductByShopId($id){
        return Products::where('products.del', 1)
                ->where('products.status', 2)
                ->where('products.shop_type_id', 1)
                ->where('shops.status', 2)
                ->where('products.date_remove', '>', date('Y-m-d H:i:s'))
                ->where('products.shop_id', $id)
                ->leftJoin('shops', 'products.shop_id', '=', 'shops.id')
                ->addSelect(
                    'products.*',
                    'shops.title as shop_title',
                    'shops.placeholder as shop_placeholder',
                    'shops.phone_numbers'
                )
                ->orderBy('products.created_at', 'desc')
                ->limit(3)
                ->get();
    }
    
    private static function getLastProduct($whereNotIn){
        return Products::where('products.del', 1)
                /*->where('products.status', 2)
                ->where('products.shop_type_id', 1)
                ->where('shops.status', 2)
                ->where('products.date_remove', '>', date('Y-m-d H:i:s'))*/
                ->whereNotIn('products.shop_id', $whereNotIn)
                ->leftJoin('shops', 'products.shop_id', '=', 'shops.id')
                ->addSelect(
                    'products.*',
                    'shops.title as shop_title',
                    'shops.placeholder as shop_placeholder',
                    'shops.phone_numbers'
                )
                ->orderBy('products.created_at', 'desc')
                ->limit(3)
                ->get();
    }
    
    public static function getById($id, $status = true){
        return Products::where('products.id', '=', $id)
                ->where('products.del', 1)
                ->where('shops.status', 2)
                ->when($status, function ($query) use ($status){
                    return $query->where('products.status', 2);
                })
                ->leftJoin('shops', 'products.shop_id', '=', 'shops.id')
                ->addSelect(
                    'products.*',
                    'shops.title as shop_title',
                    'shops.min_price',
                    'shops.cost_delivery',
                    'shops.phone_numbers',
                    'shops.logo as shop_logo',
                    'shops.payment_methods',
                    'shops.delivery_methods',
                    'shops.link_whatsapp',
                    'shops.main_phone',
                    'shops.cost_delivery',
                    'shops.placeholder',
                    'shops.schedule'
                    )
                ->firstOrFail();
    }
    
    public static function add($request, $images = '', $shop){
        return Products::insertGetId([
            'title' => $request->title,
            'user_id' => Auth::user()->id,
            'category_id' => $request->category_id,
            'shop_id' => $shop->id,
            'text' => $request->text, 
            'status' => $request->status,
            'price' => $request->price,
            'discount' => $request->discount,
            'start_discount' => $request->start_discount,
            'end_discount' => $request->end_discount,
            'shop_type_id' => $shop->shop_type_id,
            'images' => $images,
            'date_remove' => $request->date_remove,
        ]);
    }
    
    public static function edit($request, $images = null){
        if(!$images) $images = null;
        
        $update = [
            'title' => $request->title,
            'text' => $request->text,
            'category_id' => $request->category_id,
            'shop_id' => $request->shop_id,
            'status' => $request->status,
            'price' => $request->price,
            'discount' => $request->discount,
            'start_discount' => $request->start_discount,
            'end_discount' => $request->end_discount,
            'images' => $images,
            'date_remove' => $request->date_remove,
        ];
        return Products::where('id', $request->product_id)->update($update);
    }
    
    //получить максимальную цену
    public static function getMax($category_id = false, $shop_id = false, $filterCharIds = false){
        $query = self::getQueryPriceMaxorMin($category_id, $shop_id, $filterCharIds);
        return $query->max('price');
    }
    
    //получить минимальную цену
    public static function getMin($category_id = false, $shop_id = false, $filterCharIds = false){
        $query = self::getQueryPriceMaxorMin($category_id, $shop_id, $filterCharIds);
        return $query->min('price');
    }
    
    public static function getQueryPriceMaxorMin($category_id = false, $shop_id = false, $filterCharIds = false){
        return Products::leftJoin('shops', 'products.shop_id', '=', 'shops.id')
                ->where('shops.status', 2)
                ->where('products.price', '>', 0)
                ->where('products.status', 2)
                ->where('products.del', 1)
                ->where('products.date_remove', '>', date('Y-m-d H:i:s'))
                ->when($category_id, function ($query) use ($category_id) {
                    if(is_array($category_id)){
                        return $query->whereIn('products.category_id', $category_id);
                    }
                    else{
                        return $query->where('products.category_id', $category_id);
                    }
                })
                ->when($shop_id, function ($query) use ($shop_id) {
                    return $query->where('products.shop_id', $shop_id);
                })
                ->when($filterCharIds, function ($query) use ($filterCharIds) {
                    $query->join('chars_products', 'products.id', '=', 'chars_products.product_id')
                    ->addSelect(
                        'chars_products.char_id'
                    );
                    foreach($filterCharIds as $id){
                        $query->where('chars_products.char_id', $id);
                    }
                });
    }
    
    public static function countProductsChar($filterCharIds, $price, $category_id){
        $query = Products::select('chars_products.*')->join('chars_products', 'products.id', '=', 'chars_products.product_id')
                ->leftJoin('shops', 'products.shop_id', '=', 'shops.id');
        
        foreach($filterCharIds as $id){
            $query->orWhere('chars_products.char_id', (int) $id);
        }
        
        $query->groupBy('chars_products.product_id')
            ->havingRaw('COUNT(chars_products.char_id) = '.count($filterCharIds));
        
        $query->when($price, function ($query) use ($price){
            return $query->whereBetween('products.price', $price);
        });
        
        $query->where('products.category_id', $category_id)
        ->where('products.status', 2)
        ->where('products.del', 1)
        ->where('products.date_remove', '>', date('Y-m-d H:i:s'))
        ->where('shops.status', 2);

        $sql = $query->toSql();
        foreach ($query->getBindings() as $binding) {
            $sql = str_replace_first('?', "'{$binding}'", $sql);
        }
        
        return DB::table(DB::raw('('.$sql.') AS `chars_products`'))->count();
    }
    
    private function str_replace_first($from, $to, $subject){
        $from = '/'.preg_quote($from, '/').'/';
        return preg_replace($from, $to, $subject, 1);
    }
    
    public static function index($category_id = false, $filterCharIds = false, $price = false, $getCount = false, $shop_id = false, $sort = false, $getPrice = false){
        $query = Products::leftJoin('shops', 'products.shop_id', '=', 'shops.id');
        
            if($getCount){
                $query->addSelect(
                    'products.id'
                );
            }
            else{
                $query->addSelect(
                    'products.*',
                    'shops.title as shop_title',
                    'shops.main_phone',
                    'shops.phone_numbers',
                    'shops.placeholder'
                );
            }
        
            $query->when($filterCharIds, function ($query) use ($filterCharIds) {
                $query->join('chars_products', 'products.id', '=', 'chars_products.product_id')
                ->addSelect(
                    'chars_products.char_id'
                );
                foreach($filterCharIds as $id){
                    $query->orWhere('chars_products.char_id', $id);
                }
                $query->groupBy('products.id')->havingRaw('COUNT(chars_products.char_id) = '.count($filterCharIds));
            })
            ->when($category_id, function ($query) use ($category_id) {
                if(is_array($category_id)){
                    return $query->whereIn('products.category_id', $category_id);
                }
                else{
                    return $query->where('products.category_id', $category_id);
                }
            })
            ->when($shop_id, function ($query) use ($shop_id) {
                return $query->where('products.shop_id', $shop_id);
            })
            ->when($price, function ($query) use ($price) {
                return $query->whereBetween('products.price', $price);
            })
            ->when($sort, function ($query) use ($sort) {
                if($sort == 'rating'){//рейтинг
                    return $query->orderBy('products.rating', 'desc');
                }
                elseif($sort == 'price'){//по возрастанию
                    return $query->orderBy('products.price', 'desc');
                }
                elseif($sort == '-price'){//по убыванию
                    return $query->orderBy('products.price', 'asc');
                }
                elseif($sort == 'new'){//новые
                    return $query->orderBy('products.id', 'desc');
                }
                elseif($sort == 'discount'){
                    return $query->orderBy('products.discount', 'desc');
                }
                else{
                    return $query->orderBy('products.id', 'desc');
                }
            });
                
        $query->where('products.status', 2)
        ->where('products.del', 1)
        ->where('shops.status', 2)
        ->where('products.date_remove', '>', date('Y-m-d H:i:s'));
                
        //по умолчанию сортируем по id
        if(!$sort){
            $query->orderBy('products.id', 'desc');
        }
        if($getCount){
            return $query->get()->count();
        }
        
        return $query->paginate(12);
    }
    
    //получить характеристики в которых есть товары
    public static function getChars($category_id){
        return Products::select('chars.*', DB::raw('count(`chars_products`.`product_id`) as productsCount'))
                ->join('chars_products', 'products.id', '=', 'chars_products.product_id')
                ->leftJoin('chars', 'chars_products.char_id', '=', 'chars.id')
                ->leftJoin('shops', 'products.shop_id', '=', 'shops.id')
                ->where('products.category_id', $category_id)
                ->where('products.status', 2)
                ->where('products.del', 1)
                ->where('products.date_remove', '>', date('Y-m-d H:i:s'))
                ->where('shops.status', 2)
                ->groupBy('chars_products.char_id')
                ->get();
    }
    
    public static function getProductsByShop($shop_id){
        return Products::select('id', 'category_id')
                ->where('del', 1)
                ->where('status', 2)
                ->where('products.date_remove', '>', date('Y-m-d H:i:s'))
                ->where('shop_id', $shop_id)
                ->get();
    }
    
    public static function getWishlists($ids){
        $products = Products::orderBy('products.id', 'ask')
                ->leftJoin('shops', 'products.shop_id', '=', 'shops.id')
                ->addSelect(
                    'products.*',
                    'shops.title as shop_title',
                    'shops.status as shop_status',
                    'shops.phone_numbers'
                )
                ->where('shops.status', 2)
                ->where('products.del', 1)
                ->where('products.status', 2)
                ->where('products.date_remove', '>', date('Y-m-d H:i:s'))
                ->whereIn('products.id', $ids)
                ->paginate(12);
        
        //получить отзывы запрошенных товаров
        //$reviews = Reviews::getAllReviewsByProductId($products->pluck('id'));
        
        //рачитать рейтинг и количество отзывов
        //$products = self::calculateRatingAndReviews($products, $reviews);
        
        return $products;
    }
    
    //рачитать рейтинг и количество отзывов
    private static function calculateRatingAndReviews($products, $reviews){
        if($products){
            foreach ($products as $product){
                $rating = 0;
                $countReviews = 0;
                if($reviews){
                    foreach ($reviews as $review) {
                        if($product->id == $review->product_id){
                            $countReviews++;
                            $rating += $review->rating;
                        }
                    }
                    if($rating and $countReviews){
                        $rating = $rating / $countReviews;
                    }
                }
                $product->rating = $rating;
                $product->countReviews = $countReviews;
            }
        }
        return $products;
    }
    
    public static function getWishlistIds(){
        if(isset($_COOKIE['wishlist'])){
            return json_decode($_COOKIE['wishlist']);
        }
        return [];
    }
    
    public static function getWishlistCount(){
        if(isset($_COOKIE['wishlist'])) return count(json_decode($_COOKIE['wishlist']));
        else return 0;
    }
    
    public static function search($arrayWord){
        return Products::orderBy('products.id', 'asc')
            ->leftJoin('shops', 'products.shop_id', '=', 'shops.id')
            ->leftJoin('chars_products', 'chars_products.product_id', '=', 'products.id')
            ->leftJoin('chars', 'chars_products.char_id', '=', 'chars.id')
            //->select('products.*', DB::raw('GROUP_CONCAT(chars.title) as chars_title'))
            ->select('products.*')
            ->where('products.status', 2)
			->where('products.del', 1)
            ->where('products.shop_type_id', 1)
            ->where('products.date_remove', '>', date('Y-m-d H:i:s'))
            ->where('shops.status', 2)
            ->groupBy('products.id')
            ->where(function ($query) use ($arrayWord){
                //$arrayWord = explode(' ', trim($words));
                foreach ($arrayWord as $value) {
                    $query->orWhere('shops.title', 'like', '%'.$value.'%');
                    $query->orWhere('shops.short_description', 'like', '%'.$value.'%');
                    $query->orWhere('products.title', 'like', '%'.$value.'%');
                    $query->orWhere('products.text', 'like', '%'.$value.'%');
                    $query->orWhere('chars.title', 'like', '%'.$value.'%');
                }
            })
            ->paginate(10);
    }
    
    public static function remove($id){
        $update = [
            'del' => 2
        ];
        return Products::where('id', $id)->update($update);
    }
    
    //получить товары других категорий исключая магазин текущего товара
    public static function getProductsOtherCategories($product){
        return Products::orderBy('products.id', 'ask')
                ->where('products.del', 1)
                ->where('products.shop_type_id', $product->shop_type_id)
                ->where('products.shop_id', '!=', $product->shop_id)
                ->where('products.category_id', $product->category_id)
                ->where('products.status', 2)
                ->where('shops.status', 2)
                ->where('products.date_remove', '>', date('Y-m-d H:i:s'))
                ->leftJoin('shops', 'products.shop_id', '=', 'shops.id')
                ->addSelect(
                    'products.*',
                    'shops.title as shop_title',
                    'shops.phone_numbers',
                    'shops.main_phone'
                    )
                ->limit(8)
                ->get();
    }
    
    public static function getCart($ids, $shop_id = false){
        return Products::orderBy('products.id', 'ask')
                ->when($shop_id, function ($query) use ($shop_id) {
                    return $query->where('shop_id', $shop_id);
                })
                ->whereIn('products.id', $ids)
                ->leftJoin('shops', 'products.shop_id', '=', 'shops.id')
                ->addSelect(
                    'products.*',
                    'shops.title as shop_title',
                    'shops.min_price',
                    'shops.id as shop_id',
                    'shops.logo as shop_logo',
                    'shops.payment_methods',
                    'shops.delivery_methods',
                    'shops.link_whatsapp',
                    'shops.cost_delivery',
                    'shops.map_2gis_url',
                    'shops.contacts',
                    'shops.main_phone'
                )
                ->where('products.del', 1)
                ->where('products.status', 2)
                ->where('shops.status', 2)
                ->where('products.date_remove', '>', date('Y-m-d H:i:s'))
                ->get();
    }

    public static function getCartIds(){
        if(isset($_COOKIE['cart'])){
            $array = json_decode($_COOKIE['cart']);
            if(is_array($array)){
                $ids = [];
                foreach ($array as $key => $val) {
                    $ids[] = $val->id;
                }
                return $ids;
            }
            
        }
        return [];
    }
    
    public static function getCartCount(){
        if(isset($_COOKIE['cart'])) return count(json_decode($_COOKIE['cart']));
        else return 0;
    }
    
    public static function removeCookieCart(){
        setcookie ('cart', '' , time()-3600, '/'); 
    }
    
    public static function updateCookieCart($data){
        setcookie ('cart', json_encode($data), time()+3600, '/'); 
    }
    
    public static function getCookieCart(){
        if(isset($_COOKIE['cart'])){
            $array = json_decode($_COOKIE['cart']);
            $newArray = [];
            if($array){
                foreach ($array as $key => $val) {
                    $newArray[$val->id] = $val;
                }
            }
            return $newArray;
        }
    }
    
}