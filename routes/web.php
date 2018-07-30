<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', 'HomeController@index');
Route::group(['prefix' => 'voucher'], function() {
    Route::post('/generate', 'VoucherController@generateVoucher');
    Route::post('/add', 'VoucherController@addVoucher');
    Route::get('vouchers', 'VoucherController@listVouchers');
    Route::post('assign/user', 'VoucherController@assignUser');
});
Route::get('/special/offers/list', 'HomeController@retrieveSpecialOffers');
Route::post('/users/list', 'HomeController@retrieveUsers');
Route::get('/users/list', 'HomeController@retrieveUsers');
