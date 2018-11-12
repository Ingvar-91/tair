<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Mail;

class SendEmailVendorProducts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $mailData;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->mailData = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(){
        $data = $this->mailData;
        Mail::send('emails/send_email_vendor_products', $data, function($message) use ($data){
            $message->from(config('mail.from.address'));//от кого
            $message->to(config('app.contacts.email'));//кому отправляем
            $message->subject('Письмо со страницы товаров');//тема письма
        });
        
    }
}
