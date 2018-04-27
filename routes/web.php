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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'web'], function(){
	Route::auth();
});

Route::group(['middleware' => ['web','auth']], function() {
	Route::get('/home','HomeController@index');
	Route::get('/', function(){
		if(Auth::user()->admin == 1){
			return view('admin_home');
		} else {
			return view('user_home');
		}
	});
	Route::get('/order','OrderController@index');
	Route::post('/order/{id}','OrderController@store');
	Route::post('/calc-coupon','OrderController@calc_coupon');
	Route::get('/report-user','ReportController@user_index');
	Route::post('/report-user/{id}','ReportController@showData');
	Route::post('/pesan/{id}','OrderController@pesan');
});

Route::group(['middleware' => ['web','auth','admin']], function() {
	Route::resource('coupon','CouponController');
	Route::get('/report','ReportController@index');
	Route::post('/report/save','ReportController@savecsv');
});

Route::get('/password/reset/{id}', function() {
	return view('auth.password.reset');
});

Route::get('/coba',function() {
	return view('coba');
});

