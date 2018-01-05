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

Route::get('/redirect', 'LoginController@redirectPath')
	->name('redirect');

/** Login and Logout - STA **/
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

/** Login and Logout - END **/

/** Sign Up - STA **/
Route::get('/signup', 'Auth\RegisterController@view')
	->name('signup_page');
Route::post('/signup', 'Auth\RegisterController@authenticate')
	->name('signup');
Route::get('/verify/{confirmCode}', 'Auth\RegisterController@verify')
	->name('verify');

/** Sign Up - END **/

/** Survey - Order - STA **/
Route::middleware('auth')->group(function() {
	Route::get('/home', 'InitPageController@viewHomePage')
		->name('home_page');
});

Route::get('/survey/{serviceId}', 'SurveyController@view')
	->name('survey_page');
Route::post('/order/details', 'SurveyController@submitOrderDetails')
	->name('submit_order_details');

/** Survey - Order - END **/

/** Pro - STA **/
Route::middleware('pro')->group(function() {
	Route::get('/dashboard', 'InitPageController@viewDashboardPage')
		->name('dashboard_page');
	Route::get('/pro', 'Pro\ProProfileController@view')
		->name('pro_profile_page');
	Route::post('/pro/change', 'Pro\ProProfileController@changeProfile')
		->name('change_pro_profile');
	Route::post('/pro/avatar/change', 'Pro\ProProfileController@changeAvatar')
		->name('change_pro_avatar');
	Route::get('/pro/companies', 'Pro\ProProfileController@getCompanies')
		->name('get_companies');
});

// 	Route::get('/pro/companies', 'Pro\ProProfileController@getCompanies')
// 	->name('get_companies');

Route::post('/password/change', 'Pro\ProProfileController@changePassword')
	->name('change_password');

/** Pro - END **/




Route::get('/test', 'InitPageController@test');
