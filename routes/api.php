<?php

use Illuminate\Http\Request;

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

Route::namespace('Api')->group(function() {
    Route::middleware('api')->group(function() {
        Route::post('user/add', 'VoucherController@addUser');
        Route::post('voucher/create', 'VoucherController@createVoucher');
        Route::get('vouchers', 'VoucherController@listVouchers');
        Route::post('/voucher/redeem', 'VoucherController@redeemVoucher');
        Route::post('/email', 'VoucherController@getValidVoucherCodesByEmail');
    });
});
