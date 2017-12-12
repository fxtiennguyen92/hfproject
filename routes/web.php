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

// HF Routes
Route::get('/', 'InitPageController@view')
	->name('view_init_page');
Route::get('/login', 'Auth\LoginController@view')
	->name('view_login_page');
Route::post('/login', 'Auth\LoginController@authenticate');

Route::get('/logout', 'Auth\LoginController@logout');

// Partner
Route::get('/partner/signup', 'Auth\RegisterController@view')
	->name('view_sign_up_page');
Route::post('/partner/signup', 'Auth\RegisterController@authenticate');
Route::get('/partner/verify/{confirmCode}', 'Auth\RegisterController@verify');


Route::get('/test', 'InitPageController@test');

Route::get('/mail', 'MailController@sendSignUpConfirmMail');

	
