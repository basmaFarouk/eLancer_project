<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class AuthTokensController extends Controller
{

    public function index(Request $request){
        return $request->user()->tokens;
    }

    public function store(Request $request){

      $data=  $request->validate([
            'email'=>['required','email'],
            'password'=>['required'],
            'device_name'=>['required'],
            'fcm_token'=>['nullable'],
        ]);

       // Auth::validate($data); //بس هي كده مش هترجعلي اليوزر وانا محتجاه

       $user=User::where('email',$request->email)->first();
       if($user && Hash::check($request->password,$user->password)){

           $token= $user->createToken($request->device_name,['projects.create','projects.update'],$request->fcm_token);
           return Response::json([
            'token'=>$token->plainTextToken,
            'user'=>$user,
           ],201);
       }
       return Response::json([
        'message'=>'Invalid Credentials',

       ],401);
    }


    public function destroy($id){
        $user=Auth::guard('sanctum')->user();
        dd($user->currentAccessToken());
        //LogOut from the current device
        return $user->currentAccessToken()->delete();

        $user->tokens()->findOrFail($id)->delete();

        return [
            'message'=>'token deleted'
        ];
    }
}
