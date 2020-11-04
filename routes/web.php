<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\TweetsController;
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

// Route::get('/', [UsersController::class,'hoge']);
// Route::get('/{userrrr}',[UsersController::class,'hoge']);



Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function() {

    Route::resource('users',UsersController::class,
   ['only'=> ['index','show','edit','update']]);

  
   
   Route::post('users/{user}/follow', [UsersController::class,'follow'])->name('follow');
   Route::delete('users/{user}/unfollow', [UsersController::class,'unfollow'])->name('unfollow');  
 
   Route::resource('tweets',TweetsController::class, ['only' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']]);

});