<?php
namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Site\News;

use Jenssegers\Date\Date; 

class NewsController extends Controller{

    const tmpl = 'site/news/';

    public function index(Request $request){
        $this->data['posts'] = News::index(2);
        return view(self::tmpl.'index', $this->data);
    }

    public function post(Request $request){
        $this->data['post'] = News::getDataById($request->id);
        return view(self::tmpl.'post', $this->data);
    }
}
