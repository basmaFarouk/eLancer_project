<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Freelancer\ProfileRequest;
use App\Models\Freelancer;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    //
    public function edit(){
        $user=Auth::user();
        // return $user->freelancer->birthday->format('d/m/Y');  for Casting

        $profile = $user->freelancer;
        // $profile= Freelancer::where('user_id',$user->id)->get();
        // dd($profile);
        $skills=$user->skills()->pluck('name')->toArray();
        return view('freelancer.profile.edit',['user'=>$user,'profile'=>$profile,'skills'=>$skills]);
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

        if($request->hasFile('cv')){
            $file=$request->cv;
            if($file->isValid()){
                $path=$file->store('/cv',[
                    'disk'=>'uploads',
                ]);
                $data['attachment']=$path;
            }
        }
        // dd($data);

        $user=Auth::user();
        $user->freelancer()->updateOrCreate(['user_id'=>$user->id],$data);
        $user->name=$request->first_name.' '.$request->last_name;
        $user->save();
        $skills=$request->input('skills');
        $skills=explode(',',$skills);
        $skill_arr=[];
        foreach($skills as $skill){
            $skill=Skill::firstOrCreate([
                'slug'=>Str::slug($skill)
            ],[
                'name'=> $skill
            ]);
            $skill_arr[]=$skill->id;
        }
        $user->skills()->sync($skill_arr);

        // $tags_id=[];
        // foreach($tags as $tag_name){
        //    $tag = Tag::firstOrCreate([
        //     'slug'=>Str::slug($tag_name)
        //    ],[
        //     'name'=>$tag_name
        //    ]);
        //    $tags_id[]=$tag->id;
        // }

        // $this->tags()->sync($tags_id);


        return redirect()->route('freelancer.profile.edit')->with(['message'=>'Profile Updated']);


    }

    public function show($id){
        $user=User::with('freelancer')->find($id);
        // dd($user);
        return view('freelancer.profile.show',['user'=>$user]);
    }


    public function password(){
        return view('freelancer.profile.password');
    }

    public function passwordEdit(Request $request){
        // dd($request);
        $request->validate([
            'current_pass'=>['required'],
            'password'=>['required','confirmed'],
        ]);

        $user=Auth::user();
        if(Hash::check($request->current_pass,$user->password)){
            $user->forceFill([
                'password' => Hash::make($request->password),
            ])->save();;

            return redirect()->route('freelancer.password.show')->with('message','Passowrd Updated');
        }else{
            dd('notEqual');
        }
    }


}
