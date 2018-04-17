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
});

Route::get('admin', ['middleware' => ['web','auth','admin'], function() {
	return view('admin/admin_home');
}]);

Route::get('/password/reset/{id}', function() {
	return view('auth.password.reset');
});

Route::get('/order','OrderController@index');