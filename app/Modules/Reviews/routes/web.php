<?php

use App\Modules\Reviews\Http\Controllers\ReviewsController;
use Illuminate\Support\Facades\Route;

Route::get('/reviews',[ReviewsController::class,'index'])->name('reviews.index');
Route::post('/reviews',[ReviewsController::class,'store'])->name('reviews.store');
