<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Site\Controller;

class RulesController extends Controller {

    const tmpl = 'site/rules/';
    
    public function index(){
        return view(self::tmpl.'index', $this->data);
    }
}
