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

Route::get('/', 'HomeController@index');

Route::get('/user', ['uses' => 'TestController@index']);
Route::resource ('user', 'TestController');





// stock
Route::get('/stock', ['uses' => 'StockController@index']);
Route::get('/CreateStock', ['uses' => 'StockController@create']);
Route::post('/CreateStocks', ['uses'=>'StockController@store']);
Route::put('/StoreUpdate/{id}', ['uses'=>'StockController@update']);
// end stock


// user
Route::get('/userSignup', ['uses' => 'userController@create']);
Route::post('/create', ['uses'=>'userController@store']);
Route::get('/users/{id}/edit', ['uses' =>'userController@show']);
Route::get('/userList', ['uses' => 'userController@index']);
// end user



// cart
Route::get('/cart', ['uses' => 'CartController@index']);
Route::post('/addtocart', ['uses'=>'CartController@store']);
Route::put('/CartItemUpdate/{id}', ['uses'=>'CartController@update']);
Route::get('/DelItem/{id}', ['uses'=>'CartController@destroy']);
// end cart

Route::get('/paymentList', ['uses' => 'paymentController@index']);
Route::get('paymentReport',['uses'=>'paymentController@paymentReport']);

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

// price
Route::get('/price/{id}/create', ['uses' => 'PriceController@show']);
Route::post('/pricecreate', ['uses'=>'PriceController@store']);
// end price


// payment
Route::post('/CreateBill', ['uses'=>'paymentController@store']);
Route::get('/payment/{id}', ['uses' => 'paymentController@show']);
// end payment

Route::get('/test', ['uses'=>'TestController@index']);




