<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Site\Controller;

class FaqController extends Controller {

    const tmpl = 'site/faq/';
    
    public function index(){
        return view(self::tmpl.'index', $this->data);
    }
}
