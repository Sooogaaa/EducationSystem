<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\TopController;
use App\Http\Controllers\Admin\CurriculumController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\BannerController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::prefix('admin')->namespace('Admin')->name('show.')->group(function () {
    // 承認された管理者トップページ
    Route::get('top', [TopController::class, 'showTop'])->name('top');

    // ログアウト
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::prefix('auth')->namespace('Auth')->group(function () {
        // 管理者登録画面のルート
        Route::get('register', [RegisterController::class, 'showRegisterForm'])->name('register');
        Route::post('register', [RegisterController::class, 'register'])->name('register.create');

        // 管理者ログイン画面のルート
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [LoginController::class, 'login'])->name('login.send');
    });




    // 授業管理のルート
    // Route::get('curriculum/list', [CurriculumController::class, 'showCurriculumList'])->name('admin.show.curriculum.list');

    // お知らせ管理のルート
    // Route::get('article/list', [ArticleController::class, 'showArticleList'])->name('admin.show.article.list');

    // バナー管理のルート
    // Route::get('banner/edit', [BannerController::class, 'showBannerEdit'])->name('admin.edit.banner.list');
});



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
