<?php

use App\Http\Controllers\Client\ProjectsController;
use Illuminate\Support\Facades\Route;


Route::group([
    'prefix'=>'client',
    'as'=>'client.',
    'middleware'=>['auth'],
],function(){
    Route::resource('projects',ProjectsController::class);
});

// Route::delete('attachment/{id}/{name}',[ProjectsController::class,'deleteAttchment']);
//projects.index قبل ما اعمل النيمز هيروح على الاسم ده
// Route::resource('projects',ProjectsController::class)->names([
//     'indes'=>'client.projects.index',
//     'create'=>'clients.projects.create'
// ]);

