<?php

namespace App\Http\Controllers;

use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OtpController extends Controller
{
    //
    public function create(){
        return view('otp.create');
    }

    public function store(Request $request){
        $request->validate([
            'mobile_number'=>['required'],
        ]);

        $client=$this->getClient();

        $request = new \Vonage\Verify\Request($request->mobile_number, "Vonage");
        $response = $client->verify()->start($request);
        session()->put('vonage.verify.requestId',$response->getRequestId());

        return redirect()->route('otp.verify');
    }

    public function verifyForm(){
        return view('otp.verify');
    }

    public function verify(Request $request){
        $request->validate([
            'code'=>['required'],
        ]);
        $client=$this->getClient();

        try{

            $requestId=session()->get('vonage.verify.requestId');


            $result = $client->verify()->check($requestId, $request->post('code'));

            // dd($result->getResponseData());
        }catch(\Vonage\Client\Exception\Request $e){
            return redirect()->back()->with('message',$e->getMessage());
        }

        Session::forget('vonage.verify.requestId');
        return redirect('/');
    }

    protected function getClient(){

        $basic  = new \Vonage\Client\Credentials\Basic(config('services.vonage.key'), config('services.vonage.secret'));
        $client = new \Vonage\Client(new \Vonage\Client\Credentials\Container($basic));
        return $client;
    }
}
