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

Route::post('/register', 'API\AuthController@register');
Route::post('/login', 'API\AuthController@login');

Route::get('/product-list','API\ProductController@productList');

Route::middleware('auth:api')->group( function () {
    Route::get('/add-to-cart/{id}','API\CartController@addToCart');
    Route::delete('/delete-cart-item/{id}','API\CartController@deleteCartItem'); 
    Route::post('/order','API\OrderController@order');

});



