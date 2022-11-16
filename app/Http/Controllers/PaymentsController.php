<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Services\Payments\Thawani;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PaymentsController extends Controller
{
    public function create(){
        $client = new Thawani(
            config('services.thawani.secret_key'),
            config('services.thawani.publishable_key'),

        );
        $data=[
            //$data['client_reference_id']
            'client_reference_id'=>'test payment 1',
            'mode'=>'payment',
            'products'=>[ //كل برودكت عبارة عن ارراي
                [
                    'name'=>'Test Product',
                    'unit_amount'=>100*100,
                    'quantity'=>2,
                ],
            ],
            'success_url'=>route('payments.success'),
            'cancel_url'=>route('payments.cancel'),

        ];
        try{

            $session_id=$client->createCheckOutSession($data);
            $payment=Payment::forceCreate([
                'user_id'=>Auth::id(),
                'gateway'=>'thawani',
                'reference_id'=>$session_id,
                'amount'=>100*100,
                'status'=>'pending'
            ]);
            Session::put('payment_id',$payment->id);
            Session::put('session_id',$session_id);

            return redirect()->away($client->getPayURL($session_id));
        }catch(Exception $e){
            dd($e->getMessage());
        }

    }
}
