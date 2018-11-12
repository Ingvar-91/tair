<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use Auth;

class HomeController extends Controller {

    const tmpl = 'admin/home/'; //путь до шаблонов

    public function index() {
        return redirect('/admin/orders');
    }

}
