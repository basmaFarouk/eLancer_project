<?php

use App\Http\Controllers\Freelancer\ProfileController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix'=>'freelancer',
    'as'=>'freelancer.', //as for route name .. route name is freelancer.profile.edit
    'middleware'=>['auth'],
],function(){
    Route::get('profile',[ProfileController::class,'edit'])->name('profile.edit');
    Route::put('profile',[ProfileController::class,'update']);
});
