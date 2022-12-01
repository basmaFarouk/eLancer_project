<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobListController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\PaymentsCallbackController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::get('/', function () {
//     return view('home');
// })->name('home');
// Route::get('/', [HomeController::class,'index'])->name('home');

Route::group([
    //'prefix'=>'{local}', //local is parameter
    'prefix' =>LaravelLocalization::setlocale(),
],function(){
    Route::get('/', [HomeController::class,'index'])->name('home');

    Route::get('projects/{project}',[ProjectsController::class,'show'])->name('projects.show')->middleware('auth');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Route::group(['prefix'=>'admin','as'=>'admin.'],function(){
//     require __DIR__.'/auth.php';
// });

// require __DIR__.'/auth.php';

//Message Routes

Route::get('messages',[MessagesController::class,'create'])->name('messages');
Route::post('messages',[MessagesController::class,'store']);

//OTP Routes
Route::get('otp/request',[OtpController::class,'create'])->name('otp.create');
Route::post('otp/request',[OtpController::class,'store']);
Route::get('otp/verify',[OtpController::class,'verifyForm'])->name('otp.verify');
Route::post('otp/verify',[OtpController::class,'verify']);


Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
->middleware(['signed', 'throttle:6,1'])
->name('verification.verify');

//For Languae
// Route::get('/en',function(){
//     return view('home');
// })->name('english');

// Route::get('/ar',function(){
//     return view('home');
// })->name('arabic');

Route::get('jobs',[JobListController::class,'index'])->name('jobs.index');
Route::get('jobs/{id}',[JobListController::class,'show'])->name('jobs.show')->middleware('auth');

//USers
Route::get('/users',[UserController::class,'index'])->name('users.index');
Route::delete('/users/{user}',[UserController::class,'destroy'])->name('users.destroy');
Route::get('/user/assignrole/{id}',[UserController::class,'create'])->name('users.assignrole');
Route::put('/user/assignrole/{id}',[UserController::class,'update'])->name('users.update');

// Route::get('markread',function(){
//     $user=Auth::user();
//     $userUnreadNotification= $user->unreadNotifications;
//     foreach($userUnreadNotification as $notification){
//         $notification->markAsRead();
//     }
//    return redirect()->back();
// })->name('mark');

////////// Payments Routes
Route::get('/payments/create',[PaymentsController::class,'create'])->name('payments.create');
Route::get('/payments/callback/success',[PaymentsCallbackController::class,'success'])->name('payments.success');
Route::get('/payments/callback/cancel',[PaymentsCallbackController::class,'cancel'])->name('payments.cancel');

require __DIR__.'/dashboard.php';
require __DIR__.'/freelancer.php';
require __Dir__.'/client.php';

