<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\SiteOptionsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('login', [LoginController::class, 'showLoginForm'])->name('showLoginForm')->middleware('guest');
Route::get('register', [RegisterController::class, 'showRegisterForm'])->name('showRegisterForm')->middleware('guest');

Route::post('login', [LoginController::class, 'authenticate'])->name('login');
Route::post('register', [RegisterController::class, 'register'])->name('register');

Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('upload', function () {
    return view('upload');
});

Route::post('upload', function (\Illuminate\Http\Request $request) {
    $uploadedFileUrl = \CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary::upload($request->file('file')->getRealPath())->getSecurePath();
    dd($uploadedFileUrl);
});

Route::resource('post', PostsController::class);

Route::resource('product', ProductsController::class);

Route::resource('category', CategoriesController::class);

Route::resource('siteoption', SiteOptionsController::class);

Route::middleware('auth')->get('/', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

// Route::redirect('/', 'post');
