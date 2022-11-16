<?php

namespace App\Channels;

use Exception;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class Nepras{

    protected $baseUrl="https://www.nsms.ps";

    protected $url="https://www.nsms.ps/api.php?comm=sendsms&user=%s&pass=%s&to=%s&message=%s&sender=%s";

    public function send($notifiable,Notification $notification){

       $response= Http::baseUrl($this->baseUrl)
        ->get('api.php',[
            'comm'=>'sendsms', //for query string
            'user'=>config('services.nepras.user'),
            'pass'=>config('services.nepras.pass'),
            'to'=>$notifiable->routeNotificationForNepras(), //for mobile number
            'messgae'=>$notification->toNepras($notifiable),
            'sender'=>config('services.nepras.sender'),
        ]);

       $code= $response->body();
       if($code!=1){
        throw new Exception($code);
       }
    }
}
