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

// Partner
Route::get('/partner/sign-up', 'Partner\SignUpController@view')
	->name('view_sign_up_page');
Route::post('/partner/sign-up', 'Auth\RegisterController@signUp');
	
