<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Mail;

class SendEmailRegister implements ShouldQueue
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
        Mail::send('emails/register', array(
            'nameSite' => config('app.name'), 
            'verification_token' => $data->verification_token, 
            'email' => $data->email,
            'password' => $data->password,
            'id' => $data->id,
        ), function($message) use ($data){
            $message->from(config('mail.from.address'), config('app.name'));//от кого
            $message->to(trim($data->email));//кому отправляем
            $message->subject('Завершение регистрации');//тема письма
        });
        
    }
}
