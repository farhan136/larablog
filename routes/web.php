<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [App\Http\Controllers\LandingController::class, 'index'])->name('welcome');
Route::get('/landing/detail/{id}', [App\Http\Controllers\LandingController::class, 'show'])->name('detail_landing');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('post')->group(function () {
	Route::group(['middleware'=>'auth'], function(){ //untuk 
        Route::get('/', 'App\Http\Controllers\PostController@index');
        Route::get('/create', 'App\Http\Controllers\PostController@form');
        Route::post('/store/{id?}', 'App\Http\Controllers\PostController@store');
        Route::post('/gridview', 'App\Http\Controllers\PostController@gridview');
        Route::get('/edit/{id}/{module?}', 'App\Http\Controllers\PostController@form');
        Route::get('/detail/{id}/{module?}', 'App\Http\Controllers\PostController@form');
        Route::post('/delete', 'App\Http\Controllers\PostController@delete');
        Route::get('/delete/{hashed_id}', 'App\Http\Controllers\PostController@go_delete');    
    });      
});

Route::prefix('comment')->group(function () {
    Route::group(['middleware'=>'auth'], function(){ //untuk 
        Route::get('/create/{id}', 'App\Http\Controllers\CommentController@form');   
        Route::post('/store/{id?}', 'App\Http\Controllers\CommentController@store');
        Route::get('/edit/{id}/{id2?}', 'App\Http\Controllers\CommentController@form');  
        Route::get('/delete/{id}/{id2?}', 'App\Http\Controllers\CommentController@delete');  
    });      
});
