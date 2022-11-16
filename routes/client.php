<?php

use App\Http\Controllers\Client\ManageCandidatesController;
use App\Http\Controllers\Client\ProjectsController;
use App\Models\Role;
use Illuminate\Support\Facades\Route;


Route::group([
    'prefix'=>'client',
    'as'=>'client.',
    'middleware'=>['auth'],
],function(){
    Route::resource('projects',ProjectsController::class);
    Route::get('candidates/{id}',[ManageCandidatesController::class,'show'])->name('candidate');
    Route::get('candidates/{user_id}/{project_id}/details',[ManageCandidatesController::class,'details'])->name('candidate.details');
    Route::delete('candidates/{user_id}/{project_id}',[ManageCandidatesController::class,'destroy'])->name('candidate.delete');
    Route::get('candidates/{freelancer_id}/{proposal_id}/{project_id}/accept',[ManageCandidatesController::class,'accept'])->name('candidate.accept');
});

// Route::delete('attachment/{id}/{name}',[ProjectsController::class,'deleteAttchment']);
//projects.index قبل ما اعمل النيمز هيروح على الاسم ده
// Route::resource('projects',ProjectsController::class)->names([
//     'index'=>'client.projects.index',
//     'create'=>'clients.projects.create'
// ]);

