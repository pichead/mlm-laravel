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

// mail
Route::get('/sendemail', 'SendEmailController@index');
Route::post('/sendemail/send', 'SendEmailController@send');
// end mail


Route::get('/','HomeController@index');

Route::get('/user', ['uses' => 'TestController@index']);
Route::resource ('user', 'TestController');


// report
Route::get('/SaleReport', ['uses' => 'ReportPurchaseOrderController@index']);
Route::post('/report/sale', ['uses' => 'ReportPurchaseOrderController@show']);

Route::post('excel/download', [
    'uses'=>'ExcelController@download',
]);


// end report


// stock
// Route::get('/stock','StockController@index');

// Route::get('/stock', [
//     'uses'=>'StockController@index',
//     'middleware' => 'CheckLevel',
//     'authorized_levels' => ['1']
// ]);


// purchase 
// Route::get('/store', [
//     'uses'=>'StockController@indexstore',
//     'middleware' => 'CheckLevel',
//     'authorized_levels' => ['2','3']
// ]);

// stock
Route::get('/stock','StockController@index');
Route::get('/stock/create', ['uses' => 'StockController@create']);
Route::post('/CreateStocks', ['uses'=>'StockController@store']);
Route::put('/StoreUpdate/{id}', ['uses'=>'StockController@update']);
Route::put('/StoreDel/{id}', ['uses'=>'StockController@delstore']);
// end stock


// user
Route::get('/userSignup', ['uses' => 'userController@create']);
Route::get('/EditUser', ['uses' => 'userController@edituser']);
Route::put('/EditUser/{id}', ['uses' => 'userController@update']);
Route::post('/create', ['uses'=>'userController@store']);
Route::get('/users/{id}/edit', ['uses' =>'userController@show']);
Route::get('/userList', ['uses' => 'userController@index']);
Route::get('/Treeview', ['uses' => 'TreeviewController@index']);
Route::put('/ResetPassword', ['uses'=>'userController@resetpassword']);
Route::put('/reset', ['uses'=>'userController@passwordupdate']);
// end user

// forward mail
Route::get('/UserEmail/{id}', ['uses' => 'ForwardEmailController@show']);
Route::post('/ForwardMailCreate', ['uses'=>'ForwardEmailController@store']);
Route::put('/ForwardMailUpdate/{id}', ['uses'=>'ForwardEMailController@update']);
Route::get('/ForwardMailDel/{id}', ['uses'=>'ForwardEMailController@destroy']);
// end forward mail

// user bank
Route::get('/UserBank/{id}', ['uses' => 'UserBankController@show']);
Route::post('/BankCreate', ['uses'=>'UserBankController@store']);
Route::put('/BankUpdate/{id}', ['uses'=>'UserBankController@update']);
Route::put('/userbankDel/{id}', ['uses'=>'UserBankController@destroy']);
// end user bank


// cart
Route::get('/cart', ['uses' => 'CartController@index']);
Route::post('/addtocart', ['uses'=>'CartController@store']);
Route::put('/CartItemUpdate/{id}', ['uses'=>'CartController@update']);
Route::get('/DelItem/{id}', ['uses'=>'CartController@destroy']);
//  cart api 
Route::post('api/cart/updateCart', ['uses' => 'CartController@updateCart']);
// end cart

Route::get('paymentReport',['uses'=>'paymentController@paymentReport']);

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

// price
Route::get('/price/{id}', ['uses' => 'PriceController@show']);
Route::get('/price/{id}/{item}', ['uses' => 'PriceController@showprice']);
Route::post('/pricecreate', ['uses'=>'PriceController@store']);
// end price
Route::get('api/price/loadPrice', ['uses' => 'PriceController@loadPrice']);


// payment
Route::get('/BuyList', ['uses' => 'paymentController@indexbuy']);
Route::get('/SaleList', ['uses' => 'paymentController@indexsale']);
Route::post('/payment/find', ['uses' => 'paymentController@showfind']);
Route::post('/CreateBill', ['uses'=>'paymentController@store']);
Route::get('/payment/{id}', ['uses' => 'paymentController@show']);
Route::get('/paymentdetail/{id}', ['uses' => 'paymentController@showdetail']);
Route::put('/PaymentUpdate/{id}', ['uses'=>'paymentController@update']);
Route::put('/PaymentStatusUpdate/{id}', ['uses'=>'paymentController@statusupdate']);

// end payment






Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// ajax
Route::get ('/ajaxstore', ['uses' =>'ajaxstoreController@index']);
Route::post ('/ajaxstoreadd',['uses' =>'ajaxstoreController@store']);