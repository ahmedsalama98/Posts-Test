<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use PHPUnit\TextUI\XmlConfiguration\Group;

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
    return response()->redirectTo('home');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// post routes
Route::controller(PostController::class)->name('post.')->group(function(){
Route::get('posts', 'index')->name('index');
Route::get('posts/me', 'index')->name('me');
Route::get('post/create', 'create')->name('create');
Route::post('post/store', 'store')->name('store');
Route::get('post/{id}/edit', 'edit')->name('edit');
Route::put('post/{id}/update', 'update')->name('update');
Route::delete('post/{id}/destroy', 'destroy')->name('destroy');
Route::get('post/{id}', 'show')->name('show');

});
// comment routes
Route::controller(CommentController::class)->name('comment.')->group(function(){
    Route::post('comment/{post_id}/store', 'store')->name('store');

});

// like routes
Route::controller(LikeController::class)->name('like.')->group(function(){
    Route::post('like/{post_id}/store', 'store')->name('store');
});

