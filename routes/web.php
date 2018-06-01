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
Route::get('/account', 'InitPageController@control')
	->name('control');
Route::get('/pro/{proId}/info', 'InitPageController@viewProPage')
	->name('pro_page');
Route::get('/blog/{urlName?}', 'InitPageController@viewBlogPage')
	->name('blog_page');

// Service
Route::get('/service/search', 'ServiceController@search')
	->name('service_search');
Route::get('/service/{urlName}', 'ServiceController@view')
	->name('service_view');

// Document - privacy, term of use, etc.
Route::get('/doc/{urlName}', 'InitPageController@viewDocPage')
	->name('doc_view');

// Singup Pro
Route::get('/pro/new', 'Pro\ProController@newPro')
	->name('pro_new');
Route::post('/pro/create', 'Pro\ProController@create')
	->name('pro_create');
	
// Regist Company
Route::get('/company/new', 'Mng\CompanyController@newCompany')
	->name('company_new');
Route::post('/company/create', 'Mng\CompanyController@create')
	->name('company_create');

// Password
Route::get('/password', 'Auth\PasswordController@edit')
	->name('password_edit');
Route::post('/password/update', 'Auth\PasswordController@update')
	->name('password_update');
Route::post('/password/reset', 'Auth\PasswordController@reset')
	->name('password_reset');

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

/** Service - Order - STA **/
Route::post('/order/submit', 'ServiceController@submit')
	->name('submit_order');

Route::get('/orders', 'OrderController@viewList')
	->name('order_list_page');
Route::get('/order/{orderId}', 'OrderController@view')
	->name('order_page');
Route::post('/order/pro/{proId}/accept', 'OrderController@accept')
	->name('accept_quoted_price');
Route::get('/order/pro/{proId}/info', 'OrderController@viewProPage')
	->name('order_pro_page');

Route::post('/order/process', 'OrderController@process')
	->name('process_order');
Route::post('/order/complete', 'OrderController@complete')
	->name('complete_order');
Route::post('/order/cancel', 'OrderController@cancel')
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
	Route::get('/pro/orders', 'Pro\ProOrderController@viewList')
		->name('pro_order_list_page');
	Route::get('/pro/order/{orderId}', 'Pro\ProOrderController@view')
		->name('pro_order_page');
	Route::post('/pro/order/quote', 'Pro\ProOrderController@quotePrice')
		->name('quote_price');
});


Route::middleware('pro.manager')->group(function() {
	Route::get('/pro/mng/pro', 'Pro\ProManagerController@viewProListPage')
		->name('view_pro_mng_page');
});

/** Pro - END **/

/** Common - STA **/
Route::get('/city/{code}/dist', 'CommonController@getDistByCity')
	->name('get_dist_by_city');
Route::get('/company', 'CommonController@getcompany')
	->name('get_company');
/** Common - END **/

/** Partner Acquisition - STA **/
Route::middleware('cs.pa')->group(function() {
	// Company
	Route::get('/pa/company', 'Mng\CompanyController@viewList_PA')
		->name('pa_company_list');
	Route::get('pa/company/new', 'Mng\CompanyController@newCompany')
		->name('pa_company_new');
	Route::post('/pa/company', 'Mng\CompanyController@create')
		->name('pa_company_create');
	
	// Pro
	Route::get('/pa/pro', 'Mng\ProController@viewListForPA')
		->name('pa_pro_list');
	Route::post('/pa/pro', 'Mng\ProController@createForPA')
		->name('pa_pro_create');
	Route::post('/pa/pro/{id}/delete', 'Mng\ProController@deleteForPA')
		->name('pa_pro_delete');
});
/** Partner Acquisition - END **/
	
/** Management - STA **/
Route::middleware('cs.officer')->group(function() {

	// Pro
	Route::get('/mng/pro', 'Mng\ProController@viewList')
		->name('mng_pro_list');
	Route::get('/mng/pro/{id}', 'Mng\ProController@edit')
		->name('mng_pro_edit');
	Route::post('/mng/pro/{id}/update','Mng\ProController@update')
		->name('mng_pro_update');
	Route::post('/mng/pro/{id}/active','Mng\ProController@active')
		->name('mng_pro_active');
	Route::post('/mng/pro/{id}/delete','Mng\ProController@delete')
		->name('mng_pro_delete');
	
		
	Route::post('/mng/pro/avatar', 'Mng\ProController@approveAvatar')
		->name('approve_pro_avatar');
	Route::post('/mng/pro/update_cv', 'Mng\ProController@updateCV')
		->name('update_pro_cv');
	Route::post('/mng/pro/active', 'Mng\ProController@active')
		->name('active_pro');
	
	Route::get('/mng/blogs', 'Mng\BlogController@viewList')
		->name('mng_blog_list_page');
	Route::get('/mng/blog/{urlName?}', 'Mng\BlogController@view')
		->name('mng_blog_page');
	Route::post('/mng/blog/post', 'Mng\BlogController@post')
		->name('post_blog');
	Route::post('/mng/blog/delete', 'Mng\BlogController@delete')
		->name('delete_blog');
	
	Route::get('/mng/company', 'Mng\CompanyController@viewList')
		->name('mng_company_list_page');
	Route::get('/mng/company/{id?}', 'Mng\CompanyController@view')
		->name('mng_company_page');
	Route::post('/mng/company/{id?}', 'Mng\CompanyController@modify')
		->name('modify_company');
	
	Route::get('/mng/accounts', 'Mng\AccountController@viewList')
		->name('mng_account_list_page');
	
	Route::get('/mng/orders', 'Mng\OrderController@viewList')
		->name('mng_order_list_page');
	Route::post('/mng/order/{orderNo}/cancel', 'Mng\OrderController@cancel')
		->name('mng_cancel_order');

	// Services
	Route::get('/mng/service', 'Mng\ServiceController@viewList')
		->name('mng_service_list');
	Route::get('/mng/service/new', 'Mng\ServiceController@newService')
		->name('mng_service_new');
	Route::post('/mng/service', 'Mng\ServiceController@create')
		->name('mng_service_create');
	Route::get('/mng/service/{id}', 'Mng\ServiceController@edit')
		->name('mng_service_edit');
	Route::post('/mng/service/{id}/update', 'Mng\ServiceController@update')
		->name('mng_service_update');
	Route::post('/mng/service/{id}/delete', 'Mng\ServiceController@delete')
		->name('mng_service_delete');
	Route::post('/mng/service/{id}/active', 'Mng\ServiceController@active')
		->name('mng_service_active');
	Route::post('/mng/service/{id}/publish', 'Mng\ServiceController@publish')
		->name('mng_service_publish');
	Route::post('/mng/service/{id}/unpublish', 'Mng\ServiceController@unpublish')
		->name('mng_service_unpublish');
	Route::post('/mng/service/{id}/popular', 'Mng\ServiceController@popular')
		->name('mng_service_popular');
	Route::post('/mng/service/{id}/unpopular', 'Mng\ServiceController@unpopular')
		->name('mng_service_unpopular');

	// Common parameters
	Route::get('/mng/common/{key?}', 'Mng\CommonController@viewList')
		->name('mng_common_list');
	Route::post('/mng/common/{key}', 'Mng\CommonController@createCommon')
		->name('mng_common_create');
	Route::post('/mng/common/{key}/{code}/active', 'Mng\CommonController@active')
		->name('mng_common_active');
	Route::post('/mng/common/{key}/{code}/delete', 'Mng\CommonController@delete')
		->name('mng_common_delete');

	// Document
	Route::get('/mng/doc', 'Mng\DocController@viewList')
		->name('mng_doc_list');
	Route::get('/mng/doc/new', 'Mng\DocController@newDoc')
		->name('mng_doc_new');
	Route::post('/mng/doc', 'Mng\DocController@create')
		->name('mng_doc_create');
	Route::get('/mng/doc/{id}', 'Mng\DocController@edit')
		->name('mng_doc_edit');
	Route::post('/mng/doc/{id}/update', 'Mng\DocController@update')
		->name('mng_doc_update');
	Route::post('/mng/doc/{id}/delete', 'Mng\DocController@delete')
		->name('mng_doc_delete');

});
/** Management - END **/

// Route::get('/outlocation', 'MailController@outlocation');
	
// Route::get('/test2', function () { return view('mail.out-location'); });
// Route::get('/test3', function () { return view('test3'); });
