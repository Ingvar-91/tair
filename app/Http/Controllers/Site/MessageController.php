<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Site\Controller;
use Illuminate\Http\Request;

class MessageController extends Controller {

    const tmpl = 'site/message';

    public function index(){
        if((session('message-error')) || (session('message-success')) || (session('message-info')) || (session('message-warning'))){
            return view(self::tmpl.'index', $this->data);
        }
        else return redirect('/');//если сообщения отсутствуют, редирект на главную страницу
    }

}
