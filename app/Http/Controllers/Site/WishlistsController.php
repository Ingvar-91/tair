<?php
namespace App\Http\Controllers\Site;

use App\Http\Controllers\Site\Controller;
use Illuminate\Http\Request;

use App\Http\Models\Site\Products;

class WishlistsController extends Controller{

    const tmpl = 'site/wishlists/';

    public function index(Request $request){
        $this->data['products'] = Products::getWishlists(Products::getWishlistIds());
        return view(self::tmpl.'index', $this->data);
    }

}
