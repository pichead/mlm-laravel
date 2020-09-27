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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/inventory', ['uses' => 'inventoryController@index']);
Route::get('/createGoods', ['uses' => 'inventoryController@create']);
Route::get('/userSignup', ['uses' => 'userController@create']);
Route::get('/payment', ['uses' => 'paymentController@create']);
Route::get('/paymentList', ['uses' => 'paymentController@index']);
Route::get('paymentReport',['uses'=>'paymentController@paymentReport']);
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
