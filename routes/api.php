<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->get('/posts', function (Request $request) {
    $posts = \App\Models\Post::all()->toArray();
    return array_reverse($posts);
});

Route::middleware('api')->get('/products', function (Request $request) {
    $products = \App\Models\Product::all()->toArray();
    return array_reverse($products);
});

Route::middleware('api')->get('/categories', function (Request $request) {
    $categories = \App\Models\Category::all()->toArray();
    return array_reverse($categories);
});

Route::middleware('api')->get('/siteoptions', function (Request $request) {
    $siteoptions = \App\Models\SiteOption::all()->toArray();
    return array_reverse($siteoptions);
});
