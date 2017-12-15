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

Route::get('/', 'InitPageController@viewIndexPage')
	->name('index_page');

Route::get('/home', 'InitPageController@viewHomePage')
	->name('home_page');

Route::get('/dashboard', 'InitPageController@viewDashboardPage')
	->name('dashboard_page');

Route::get('/redirect', 'LoginController@redirectPath')
	->name('redirect');

/** Login and Logout **/
Route::get('/login', 'Auth\LoginController@view')
	->name('login_page');
Route::post('/login', 'Auth\LoginController@authenticate')
	->name('login');
Route::get('/logout', 'Auth\LoginController@logout')
	->name('logout');

Route::get('/redirect/facebook', 'Auth\SocialAuthController@redirectFB')
	->name('redirect_fb');
Route::get('/callback/facebook', 'Auth\SocialAuthController@callbackFB')
	->name('callback_fb');
Route::get('/redirect/google', 'Auth\SocialAuthController@redirectGG')
	->name('redirect_gg');
Route::get('/callback/google', 'Auth\SocialAuthController@callbackGG')
	->name('callback_gg');

/** Partner **/
Route::get('/signup', 'Auth\RegisterController@view')
	->name('signup_page');
Route::post('/signup', 'Auth\RegisterController@authenticate')
	->name('signup');
Route::get('/verify/{confirmCode}', 'Auth\RegisterController@verify')
	->name('verify');


/** Partner **/
Route::get('/partner/signup', 'Auth\RegisterController@view')
	->name('partner_sign_up_page');
Route::post('/partner/signup', 'Auth\RegisterController@authenticate');

Route::get('/partner/verify/{confirmCode}', 'Auth\RegisterController@verify');




Route::get('/test', 'InitPageController@test');

Route::get('/mail', 'MailController@sendSignUpConfirmMail');

	
