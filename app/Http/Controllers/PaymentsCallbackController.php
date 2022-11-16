<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Services\Payments\Thawani;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PaymentsCallbackController extends Controller
{
    public function success(){
        // dd("ndj");
        $payment_id=Session::get('payment_id');
        $session_id=Session::get('session_id');
        if(!$payment_id && !$session_id){
             abort(404);
        }

        $payment=Payment::find($payment_id);
        if($payment->reference_id !== $session_id){
            abort(404);
        }

        $client = new Thawani(
            config('services.thawani.secret_key'),
            config('services.thawani.publishable_key'),

        );
        try{
            $response=$client->getCheckOutSession($session_id);
            // dd($response);
            if($response['data']['payment_status']=='paid'){
                $payment->status='success';
                $payment['data']=$response;
                $payment->save();
                Session::forget(['payment_id','session_id']);
                dd('Success!');
            }

            // return redirect()->route('payments.success');
        }catch(Exception $e){
            $e->getMessage();
        }
    }

    public function cancel(){
        $payment_id=Session::get('payment_id');
        $session_id=Session::get('session_id');
        if(!$payment_id && !$session_id){
            abort(404);
        }

        $payment=Payment::findOrFail($payment_id);
        if($payment->reference_id !== $session_id){
            abort(404);
        }



            $payment->status='failed';
            $payment->save();


        // return redirect()->route('payments.success');
        dd('Failed!');
    }
}
