<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\CategoriesController;

Route::get('/', function () {
    return view('home');
});

Route::group([
    'prefix'=>'/dashboard', //prefix for URI
    'as'=>'', //prefix for route name
    'middleware'=>['auth'],
],function(){
    Route::get('/categories', [CategoriesController::class, 'index'])->name('categories.index')->middleware('auth');
    Route::get('/categories/create', [CategoriesController::class, 'create'])->name('categories.create');
    Route::get('/categories/{id}', [CategoriesController::class, 'show'])->name('categories.show');
    Route::get('/categories/{category}/edit', [CategoriesController::class, 'edit'])->name('categories.edit');
    Route::post('/categories', [CategoriesController::class, 'store'])->name('categories.store');
    Route::put('/categories/{id}', [CategoriesController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoriesController::class, 'destroy'])->name('categories.destroy');
});

// Route::get('/categories',[CategoriesController::class,'index'])->name('categories.index');
// Route::get('/categories/create',[CategoriesController::class,'create'])->name('categories.create');
// Route::get('/categories/{id}',[CategoriesController::class,'show'])->name('categories.show');
// Route::get('/categories/{id}/edit',[CategoriesController::class,'edit'])->name('categories.edit');
// Route::post('/categories',[CategoriesController::class,'store'])->name('categories.store');
// Route::put('/categories/{id}',[CategoriesController::class,'update'])->name('categories.update');
// Route::delete('/categories/{id}',[CategoriesController::class,'destroy'])->name('categories.destroy');

// Route::resource('categories',CategoriesController::class);

