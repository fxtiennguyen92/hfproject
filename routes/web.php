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

Route::get('/pro/signup', 'SignUpProController@view')
	->name('signup_pro');
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
Route::get('/order/complete', 'SurveyController@complete')
	->name('complete_order');
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
});

Route::get('/companies', 'CommonController@getCompanies')
	->name('get_companies');
Route::post('/company/add', 'CommonController@addCompany')
	->name('add_company');
	

// 	Route::get('/pro/companies', 'Pro\ProProfileController@getCompanies')
// 	->name('get_companies');

Route::get('/pro/order/{orderId}', 'Pro\ProOrderController@viewOrder')
	->name('view_pro_order');
Route::post('/pro/order/quote', 'Pro\ProOrderController@quotePrice')
	->name('quote_price');
Route::get('/pro/orders/{style?}', 'Pro\ProOrderController@viewOrders')
	->name('view_pro_orders');

Route::post('/password/change', 'Pro\ProProfileController@changePassword')
	->name('change_password');
/** Pro - END **/

Route::get('/location', 'SurveyController@getLocation')
	->name('get_location');

/** Common - STA **/
Route::get('/city/{code}/dist', 'CommonController@getDistByCity')
	->name('get_dist_by_city');

/** Common - END **/


	Route::get('/test', function () { return view('complete'); });
