<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ConfigController extends Controller
{
    public function index(){
        return view('config');
    }

    public function store(Request $request){
        //Save Config to database
    //    dd($request->post('config'));

            foreach($request->post('config') as $name=>$value){
                Config::where('name',$name)->update(['value'=>$value]);
            }
        //Clear Cache

        Cache::forget('configs');

        return redirect()->route('config')->with('message','Settings has been Updated');
    }
}
