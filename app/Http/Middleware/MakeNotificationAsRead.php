<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MakeNotificationAsRead
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
        $user=$request->user();
        $notify_id=$request->query('notify_id');
        if($notify_id){
            $notification=$user->unreadNotifications()->find($notify_id);
            if($notification){
                $notification->markAsRead(); //markAsUnread()
            }
        }
        return $next($request);
    }
}
