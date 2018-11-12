<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\MobizonLib\MobizonSend;

class SendSmsNewOrder implements ShouldQueue{
    
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $smsData;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->smsData = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $array = $this->smsData;
        
        $mobizon = new MobizonSend();
        $mobizon->SendSms($array->phone, config('mobizon.messages.order'). ' Номер заказа - '.str_pad($array->id, 6, '0', STR_PAD_LEFT).' '.config('app.url'));
    }
}
