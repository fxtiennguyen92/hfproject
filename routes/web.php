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

Route::get('/', 'InitPageController@viewHomePage')
	->name('home_page');
Route::get('/redirect', 'Auth\LoginController@redirectPath')
	->name('redirect');
Route::get('/control', 'InitPageController@control')
	->name('control');

/** Password - STA **/
Route::get('/password', 'Auth\PasswordController@view')
	->name('password_page');
Route::post('/password', 'Auth\PasswordController@change')
	->name('change_password');
/** Password - END **/

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


Route::middleware('auth')->group(function() {

});
/** Service - Order - STA **/
Route::get('/dich-vu/{serviceUrlName}', 'ServiceController@view')
	->name('service_page');
Route::post('/order/details', 'ServiceController@submitOrder')
	->name('submit_order');
Route::get('/order/complete', 'ServiceController@complete')
	->name('complete_order');
Route::get('/orders', 'OrderController@viewList')
	->name('order_list_page');
Route::get('/order/{orderId}', 'OrderController@view')
	->name('order_page');
Route::post('/order/qprice/{qpId}', 'OrderController@accept')
	->name('accept_quoted_price');
Route::post('/order/{orderId}/cancel', 'OrderController@cancel')
	->name('cancel_order');
/** Service - Order - END **/

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
	Route::get('/pro/orders/{style?}', 'Pro\ProOrderController@viewList')
		->name('pro_order_list_page');
	Route::get('/pro/order/{orderId}', 'Pro\ProOrderController@view')
		->name('pro_order_page');
	Route::post('/pro/order/quote', 'Pro\ProOrderController@quotePrice')
		->name('quote_price');
});


Route::middleware('pro.manager')->group(function() {
	Route::get('pro/mng/pros', 'Pro\ProManagerController@viewProListPage')
		->name('view_pro_mng_page');
});

/** Pro - END **/

/** Common - STA **/
Route::get('/city/{code}/dist', 'CommonController@getDistByCity')
	->name('get_dist_by_city');
Route::get('/companies', 'CommonController@getCompanies')
	->name('get_companies');
/** Common - END **/

/** Management - STA **/
Route::middleware('cs.officer')->group(function() {
	Route::get('/mng/pros', 'Mng\ProController@viewList')
		->name('pro_list_page');
	Route::post('pro/mng/pro/{proId}/delete','Pro\ProManagerController@deleteByProManager')
		->name('delete_pro_by_pro_mng');

	Route::get('/mng/pro/{proId}/profile', 'Mng\ProController@viewProfile')
		->name('pro_profile_mng_page');
	Route::post('/mng/pro/avatar', 'Mng\ProController@approveAvatar')
		->name('approve_pro_avatar');
	Route::post('/mng/pro/update_cv', 'Mng\ProController@updateCV')
		->name('update_pro_cv');
	Route::post('/mng/pro/active', 'Mng\ProController@active')
		->name('active_pro');
});


Route::get('/mng/companies', 'Mng\CompanyController@viewList')
	->name('company_list_page');
Route::get('/mng/company/{id?}', 'Mng\CompanyController@view')
	->name('company_page');
Route::post('/mng/company/{id?}', 'Mng\CompanyController@modify')
	->name('modify_company');
/** Management - END **/
	
/** Alpha - STA **/
Route::get('/pro/signup', 'Pro\ProSignUpController@view')
	->name('pro_signup_page');
Route::post('/pro/signup', 'Pro\ProSignUpController@signup')
	->name('signup_pro');
/** Alpha - END **/

Route::get('/ordertemp', function () { return view('order_temp'); });
Route::get('/test', function () { return view('order_detail_temp'); });
Route::get('/test2', function () { return view('test2'); });
