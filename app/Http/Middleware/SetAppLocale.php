<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class SetAppLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user=Auth::user();
        if($user){
            $local=$user->language;
        }else{

            $accept_language=$request->header('accept-language');
           $lang_array= explode(',',$accept_language);
            // dd($lang_array[0]);
            $local=$lang_array[0] ?? 'en';
            $local=$request->query('lang',Session::get('lang','en'));
            Session::put('lang',$local);

            //make override
            $local=$request->route('local',App::getLocale());
        }
        // $locals=['ar','en'];
        // if(!in_array($local,$locals)){
        //     abort(404);
        // }
        App::setLocale($local);

        URL::defaults([
            'local'=>$local  //set default value for local parameter
        ]);

        Route::current()->forgetParameter('local');
        return $next($request);
    }
}
