<?php
namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Site\Products;

class CompareController extends Controller{

    const tmpl = 'site/compare/';

    public function index(Request $request){
        $this->data['products'] = Products::getCompare(Products::getCompareIds());
        return view(self::tmpl.'index', $this->data);
    }

}
