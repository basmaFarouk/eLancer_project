<?php

use App\Http\Controllers\Freelancer\ProfileController;
use App\Http\Controllers\Freelancer\ProposalsController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix'=>'freelancer',
    'as'=>'freelancer.', //as for route name .. route name is freelancer.profile.edit
    'middleware'=>['auth'],
],function(){
    Route::get('proposals',[ProposalsController::class,'index'])
    ->name('proposals.index');
    Route::get('proposals/{project_id}/create',[ProposalsController::class,'create'])
    ->name('proposals.create');
    Route::post('proposals/{project_id}/store',[ProposalsController::class,'store'])
    ->name('proposals.store');
    Route::delete('proposal/{id}',[ProposalsController::class,'destroy'])->name('proposal.delete');

    Route::get('profile',[ProfileController::class,'edit'])->name('profile.edit');
    Route::put('profile',[ProfileController::class,'update']);
    Route::get('profile/{id}',[ProfileController::class,'show'])->name('profile.show');
    Route::get('passowrd',[ProfileController::class,'password'])->name('password.show');
    Route::post('passowrd',[ProfileController::class,'passwordEdit'])->name('password.edit');
});
