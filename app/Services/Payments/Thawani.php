<?php

namespace App\Services\Payments;

use Exception;
use Illuminate\Support\Facades\Http;

class Thawani{

    const TEST_BASE_URL='https://uatcheckout.thawani.om/api/v1';
    const TEST_LIVE_URL='https://checkout.thawani.om/api/v1';

    protected $secret_key;
    protected $publishable_key;
    protected $base_url;
    protected $mode;

    public function __construct($secret_key,$publishable_key,$mode='test')
    {
        $this->secret_key=$secret_key;
        $this->publishable_key=$publishable_key;
        $this->mode =$mode;
        if($mode='test'){
            $this->base_url=self::TEST_BASE_URL;
        }else{
            $this->base_url=self::TEST_LIVE_URL;
        }
    }

    public function createCheckOutSession($data){
       $response= Http::baseUrl($this->base_url)
                ->withHeaders([
                    'thawani-api-key'=>$this->secret_key,
                    // 'content-type'=>'application/json',
                ])
                ->asJson()
                ->post('/checkout/session',$data);

        $body=$response->json();
        if($body['success']=='true' && $body['code']=2004){
            return $body['data']['session_id'];
        }

        throw new Exception($body['description'],$body['code']);
    }

    public function getPayURL($session_id){
        if($this->mode =='test'){

            return "https://uatcheckout.thawani.om/pay/{$session_id}?key={$this->publishable_key}";
        }

        return "https://checkout.thawani.om/pay/{$session_id}?key={$this->publishable_key}";
    }


    public function getCheckOutSession($session_id){
       $response= Http::baseUrl($this->base_url) //لما ترجع الريسبونس هات الجسون منه
        ->withHeaders([
            'thawani-api-key'=>$this->secret_key,
        ])
        ->get('checkout/session/'.$session_id)
        ->json();

        // dd($response);
        if($response['success']==true && $response['code']==2000){
            return $response;
        }

        throw new Exception($response['description'],$response['code']);
    }


}
