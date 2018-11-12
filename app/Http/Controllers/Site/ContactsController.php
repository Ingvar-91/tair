<?php
namespace App\Http\Controllers\Site;

use App\Http\Controllers\Site\Controller;
use Illuminate\Http\Request;
use Mail;

use App\Validation\Site\ContactsValidation;

class ContactsController extends Controller{
    
    use ContactsValidation;

    const tmpl = 'site/contacts/';

    public function index(Request $request){
        return view(self::tmpl.'index', $this->data);
    }
    
    public function send(Request $request){
        $this->validContacts($request);
        
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['theme'] = $request->theme;
        $data['text'] = $request->text;
        //отправляем ему письмо
        $result = Mail::send('emails/contacts', array(
            'name' => $data['name'],
            'email' => $data['email'],
            'theme' => $data['theme'],
            'text' => $data['text']
        ), function($message) use ($data){
            $message->from(config('mail.from.address'));//от кого
            $message->to(config('mail.to.address'));//кому отправляем
            $message->subject($data['theme']);//тема письма
        });
        return redirect('/contacts')->with('message-success', 'Сообщение было отправлено нам на почту, мы постараемся ответить на него как можно скорей.');
    }

}
