<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Site\Controller;
use App\Http\Models\Site\Products;
use App\Http\Models\Site\Slider;
use App\Http\Models\Site\Shops;
use App\Http\Models\Site\Brands;
use Auth;

class HomeController extends Controller {

    const tmpl = 'site/home/';

    public function index() {
        $this->data['productsDay'] = Products::getNewProduct();
        $this->data['shopsTop'] = Shops::getTopShops();
        $this->data['entertainmentPlaces'] = Shops::getTopEntertainmentPlaces();
        $this->data['slider'] = [];
        if (Slider::getAll()->first()) {
            $this->data['slider'] = array_diff(explode('|', Slider::getAll()->first()->images), ['']);
        }
        $this->data['brands'] = [];
        if (Brands::getAll()->first()) {
            $this->data['brands'] = array_diff(explode('|', Brands::getAll()->first()->images), ['']);
        }

        return view(self::tmpl . 'index', $this->data);
    }

}
