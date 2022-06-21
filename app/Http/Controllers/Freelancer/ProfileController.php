<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Freelancer\ProfileRequest;
use App\Models\Freelancer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    //
    public function edit(){
        $user=Auth::user();
        // return $user->freelancer->birthday->format('d/m/Y');  for Casting

        $profile = $user->freelancer;
        // $profile= Freelancer::where('user_id',$user->id)->get();
        // dd($profile);
        return view('freelancer.profile.edit',['user'=>$user,'profile'=>$profile]);
    }

    public function update(ProfileRequest $request){

        // $request->validate([
        //     'first_name'=>'required',
        // ]);

        // dd($request->all());
        $data=$request->all();
        if($request->hasFile('profile_photo_path')){

        //     $typesInfo= explode('.',$request->image);
        //    $extensions = strtolower(end($typesInfo));
        // //    dd($extensions);
        //     $finalName=uniqid().'.'.$extensions;
            $FinalName = uniqid().'.'.$request->profile_photo_path->extension();


            if($request->profile_photo_path->move(public_path('/profile'),$FinalName)){
               $data['profile_photo_path']=$FinalName;
            }
        }
        // dd($data);

        $user=Auth::user();
        $user->freelancer()->updateOrCreate(['user_id'=>$user->id],$data);
        $user->name=$request->first_name.' '.$request->last_name;
        $user->save();


        return redirect()->route('freelancer.profile.edit')->with(['profile'=>'updated']);


    }


}
