<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Illuminate\Support\Facades\Log;

use Mail;

class SendEmailNewOrder implements ShouldQueue
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
    public function handle()
    {
        $array = $this->mailData;
        
        //Log::info('Email '.(string)$array->email);
        
        if($array['email']){
            Mail::send('emails/order', $array, function($message) use ($array){
                $message->from(config('mail.from.address'), config('app.name'));//от кого
                $message->to($array['email']);//кому отправляем
                $message->subject('Создание заказа');//тема письма
            });
        }
        
        Mail::send('emails/order-admin', $array, function($message){
            $message->from(config('mail.from.address'), config('app.name'));//от кого
            $message->to(config('app.contacts.email'));//кому отправляем
            $message->subject('Создание заказа');//тема письма
        });
    }
}
