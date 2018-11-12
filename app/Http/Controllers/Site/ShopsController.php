<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Site\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Site\Shops;
use App\Http\Models\Site\Products;
use App\Http\Models\Site\Filter;
use App\Http\Models\Site\ProductCategories;
use App\Http\Models\Site\Characteristics;
use App\Http\Models\Site\CharacteristicsName;
use Auth;
use App\Helpers\Helper;

class ShopsController extends Controller {

    const tmpl = 'site/shops/';

    //private $product_categories = [];
    private $categoriesShop;

    public function __construct() {
        parent::__construct();
        $this->categoriesShop = collect();
    }

    public function index(Request $request) {
        if ($request->subdomain == 'www') {
            return redirect('https://tair.shop');
        }

        $shop = Shops::getByPlaceholder($request->subdomain);
        if ($shop->gallery) {
            $shop->gallery = explode('|', $shop->gallery);
        }

        if ($request->ajax()) {
            $filterCharIds = $request->filterChar;
            $price = $request->price;

            $dataAjax['countProducts'] = Products::index(false, $filterCharIds, $price, true, $shop->id);
            return response()->json($dataAjax);
        } else {
            $filterCharIds = array_filter(explode(',', $request->filterChar));
            $price = array_filter(explode(',', $request->price));

            $this->data['products'] = Products::index($request->category_id, $filterCharIds, $price, false, $shop->id, $request->sort);
            $this->data['countProducts'] = Products::index(false, $filterCharIds, $price, true, $shop->id);
        }

        //
        $productCategories = $this->getProductCategories(ProductCategories::index($shop->id));
        $this->data['categoriesShop'] = $this->buildTree($productCategories);
        
        //
        $this->data['priceMax'] = Products::getMax(false, $shop->id);
        $this->data['priceMin'] = Products::getMin(false, $shop->id);

        $this->data['shop'] = $shop;
        $this->data['linkWhatsappShop'] = $shop->link_whatsapp;
        $this->data['mainPhoneShop'] = $shop->main_phone;
        return view(self::tmpl . 'index', $this->data);
    }


}
