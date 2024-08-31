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

//ユーザ用お知らせ詳細画面へのルート
Route::get('/article/{id}', [App\Http\Controllers\User\ArticleController::class, 'showArticle'])->name('show.article');



//管理者用お知らせ一覧画面へのルート
Route::get('/article_list', [App\Http\Controllers\Admin\ArticleController::class, 'showArticleList'])->name('show.article.list');

//管理者用お知らせ新規登録画面へのルート
Route::get('/article_create', [App\Http\Controllers\Admin\ArticleController::class, 'showArticleCreate'])->name('show.article.create');

//管理者用お知らせ新規登録処理へのルート
Route::post('/article_store', [App\Http\Controllers\Admin\ArticleController::class, 'storeArticle'])->name('article.store');

//管理者用お知らせ編集画面へのルート
Route::get('/article_edit/{id}', [App\Http\Controllers\Admin\ArticleController::class, 'showArticleEdit'])->name('show.article.edit');

//管理者用お知らせ編集処理へのルート
Route::put('/article_update/{id}', [App\Http\Controllers\Admin\ArticleController::class, 'updateArticle'])->name('article.update');