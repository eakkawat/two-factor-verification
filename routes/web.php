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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'twofactor'], function(){
    Route::get('/home', 'HomeController@index')->name('home');
});

Route::get('/verifyOTP', 'verifyOTPController@show')->name('otp.index');
Route::post('verifyOTP', 'verifyOTPController@verify')->name('otp.verify');
Route::get('/resendOTP', 'verifyOTPController@resend')->name('otp.resend');

Auth::routes();




