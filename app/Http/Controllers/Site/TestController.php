<?php
namespace App\Http\Controllers\Site;

use App\Http\Controllers\Site\Controller;
use Illuminate\Http\Request;

use Mail;

class TestController extends Controller {

    const tmpl = 'site/test/';

    public function index(Request $request){
        Mail::send('emails/register', array(
            'nameSite' => config('app.name'), 
            'email' => 'ingvar-91@inbox.ru',
            'password' => '0123456789',
            'id' => 1564785,
        ), function($message){
            $message->from(config('mail.from.address'), config('app.name'));//от кого
            $message->to(trim('ingvar-91@inbox.ru'));//кому отправляем
            $message->subject('Завершение регистрации');//тема письма
        });
    }

}
