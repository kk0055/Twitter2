<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\TweetsController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\FavoritesController;




Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();



Route::group(['middleware' => 'auth'], function() {

    Route::resource('users',UsersController::class,
   ['only'=> ['index','show','edit','update']]);

  
   
   Route::post('users/{user}/follow', [UsersController::class,'follow'])->name('follow');
   Route::delete('users/{user}/unfollow', [UsersController::class,'unfollow'])->name('unfollow');  
 
   Route::resource('tweets',TweetsController::class, ['only' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']]);

  Route::resource('comments',CommentsController::class, ['only'=>['store','destroy']]);   

  Route::resource('favorites',FavoritesController::class, ['only'=>['store','destroy']]);
});

