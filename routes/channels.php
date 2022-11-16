<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) { //$id ->هو الاي دي بتاع الشخص صاحب البروجيكت
    return (int) $user->id === (int) $id;
}); //التشانل الخاصة بالنوتيفيكشن .. $user->current authenticated user

Broadcast::channel('messages.{id}',function($user,$id){
    if($user->id==$id){

        return $user;
    }
});
