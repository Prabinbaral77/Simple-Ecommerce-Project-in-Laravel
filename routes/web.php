<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('checkout',App\Http\Controllers\OrderController::class);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['as'=>'products.','prefix'=>'products'], function(){
    Route::get('/',[App\Http\Controllers\ProductController::class, 'show'])->name('all');
    Route::get('/{product}', [App\Http\Controllers\ProductController::class, 'single'])->name('single');
    Route::get('/addToCart/{product}', [App\Http\Controllers\ProductController::class, 'addToCart'])->name('addToCart');
});

Route::group(['as'=>'cart.' , 'prefix'=>'cart'], function(){
    Route::get('/',[App\Http\Controllers\ProductController::class , 'cart'])->name('all');
    Route::get('/remove/{product}',[App\Http\Controllers\ProductController::class , 'removeProduct'])->name('remove'); 
    Route::post('/update/{product}',[App\Http\Controllers\ProductController::class , 'updateProduct'])->name('update');
});

Route::group(['as'=>'admin.','middleware'=>['auth','admin'],'prefix'=>'admin'],function(){
    Route::get('/category/{category}/remove', [App\Http\Controllers\CategoryController::class, 'remove'])->name('category.remove');
    Route::get('category/trash', [App\Http\Controllers\CategoryController::class, 'trash'])->name('category.trash');
    Route::get('category/recover/{id}',[App\Http\Controllers\CategoryController::class, 'recoverCat'])->name('category.recover');

    Route::get('/product/{product}/remove', [App\Http\Controllers\ProductController::class, 'remove'])->name('product.remove');
    Route::get('product/trash', [App\Http\Controllers\ProductController::class, 'trash'])->name('product.trash');
    Route::get('product/recover/{product}',[App\Http\Controllers\ProductController::class, 'recoverProduct'])->name('product.recover');

    Route::view('product/extras','admin.partials.extras')->name('product.extras');

    Route::get('profile/{profile}/remove', [App\Http\Controllers\ProfileController::class,'remove'])->name('profile.remove');
    Route::get('profile/trash', [App\Http\Controllers\ProfileController::class,'trash'])->name('profile.trash');
    Route::get('profile/recover/{id}', [App\Http\Controllers\ProfileController::class,'recoverProfile'])->name('profile.recover');

    Route::get('profile/states/{id?}',[App\Http\Controllers\ProfileController::class,'getStates'])->name('profile.states');
    Route::get('profile/cities/{id?}',[App\Http\Controllers\ProfileController::class,'getCities'])->name('profile.cities');
    
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('product', App\Http\Controllers\ProductController::class);
    Route::resource('category', App\Http\Controllers\CategoryController::class);
    Route::resource('profile', App\Http\Controllers\ProfileController::class);
});
