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
Auth::routes();

Route::prefix('user')->namespace('User')->name('user.')->group(function () {

    

});

//ユーザ用トップ画面へのルート
Route::get('/top', [App\Http\Controllers\User\TopController::class, 'showTop'])->name('show.top');

//ユーザ用お知らせ画面へのルート
Route::get('/article/{id}', [App\Http\Controllers\User\ArticleController::class, 'showArticle'])->name('show.article');

