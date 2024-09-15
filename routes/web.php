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

//ユーザ用画面へのルート
Route::prefix('user')->namespace('User')->name('user.')->group(function () {
    //トップ画面へのルート
    Route::get('/top', [App\Http\Controllers\User\TopController::class, 'showTop'])->name('show.top');

    //お知らせ詳細画面へのルート
    Route::get('/article/{id}', [App\Http\Controllers\User\ArticleController::class, 'showArticle'])->name('show.article');

    //プロフィール変更画面へのルート
    Route::get('/profile', [App\Http\Controllers\User\ProfileController::class, 'showProfileForm'])->name('show.profile');

    //プロフィール変更処理へのルート
    Route::post('/profile_update', [App\Http\Controllers\User\ProfileController::class, 'updateProfileForm'])->name('update.profile');

    //パスワード変更画面へのルート
    Route::get('/password', [App\Http\Controllers\User\ProfileController::class, 'showPasswordForm'])->name('show.password.edit');

    //パスワード変更処理へのルート
    Route::post('/password_update', [App\Http\Controllers\User\ProfileController::class, 'updatePasswordForm'])->name('update.password');

});


//管理者用画面へのルート
Route::prefix('admin')->namespace('Admin')->name('admin.')->group(function () {
    //お知らせ一覧画面へのルート
    Route::get('/article_list', [App\Http\Controllers\Admin\ArticleController::class, 'showArticleList'])->name('show.article.list');

    //お知らせ新規登録画面へのルート
    Route::get('/article_create', [App\Http\Controllers\Admin\ArticleController::class, 'showArticleCreate'])->name('show.article.create');

    //お知らせ新規登録処理へのルート
    Route::post('/article_store', [App\Http\Controllers\Admin\ArticleController::class, 'storeArticle'])->name('article.store');

    //お知らせ編集画面へのルート
    Route::get('/article_edit/{id}', [App\Http\Controllers\Admin\ArticleController::class, 'showArticleEdit'])->name('show.article.edit');

    //お知らせ編集処理へのルート
    Route::put('/article_update/{id}', [App\Http\Controllers\Admin\ArticleController::class, 'updateArticle'])->name('article.update');

    //お知らせ削除処理へのルート
    Route::delete('/article_destroy/{id}', [App\Http\Controllers\Admin\ArticleController::class, 'destroyArticle'])->name('article.destroy');

});

