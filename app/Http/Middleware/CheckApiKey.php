<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Response;
use NunoMaduro\Collision\Adapters\Phpunit\ConfigureIO;

class CheckApiKey
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
        $key = $request->header('x-api-key');
        if($key !== config('app.api_key')){
            return Response::json([
                'message'=>'Invalid API Key',
            ],400);
        }

        $user=Auth::guard('sanctum')->user();
        if($user){

            $user->currentAccessToken()->forceFill([
                'ip_address'=>$request->ip()
            ])->save();
        }
        return $next($request);
    }
}
