<?php
namespace App\Http\Controllers\Site;

use App\Http\Controllers\Site\Controller;
use Illuminate\Http\Request;

class MessagesController extends Controller{
    
    const tmpl = 'site/messages/';

    public function index(Request $request){
        if( ($request->session()->has('message-success') == true) or ($request->session()->has('message-error') == true) or ($request->session()->has('message-warning') == true) ){
            return view(self::tmpl . 'index', $this->data);
        }
        return redirect()->route('home');
    }

}
