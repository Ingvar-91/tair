<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Site\Controller;

class AboutController extends Controller {

    const tmpl = 'site/about/';
    
    public function index(){
        return view(self::tmpl.'index', $this->data);
    }
}
