<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\TweetsController;
use App\Http\Controllers\CommentsController;
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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();



Route::group(['middleware' => 'auth'], function() {

    Route::resource('users',UsersController::class,
   ['only'=> ['index','show','edit','update']]);

  
   
   Route::post('users/{user}/follow', [UsersController::class,'follow'])->name('follow');
   Route::delete('users/{user}/unfollow', [UsersController::class,'unfollow'])->name('unfollow');  
 
   Route::resource('tweets',TweetsController::class, ['only' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']]);

  Route::resource('comments',CommentsController::class, ['only'=>['store']]);   

});

