<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/pro/{id}/info', 'InitPageController@viewProPage')
	->name('pro_page');
Route::get('/blog/{urlName?}', 'InitPageController@viewBlogPage')
	->name('blog_page');
Route::get('/search', 'InitPageController@viewSearchPage')
	->name('search_page');

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
Route::post('/password/reset/sac', 'Auth\PasswordController@getSAC')
	->name('password_reset_get_sac');

// Login
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

// Sign Up
Route::get('/signup', 'Auth\RegisterController@view')
	->name('signup_page');
Route::post('/signup', 'Auth\RegisterController@authenticate')
	->name('signup');
Route::post('/signup/sac', 'Auth\RegisterController@getSAC')
	->name('signup_get_sac');
Route::get('/verify/{code}', 'Auth\RegisterController@verify')
	->name('signup_verify');

// Wallet
Route::post('/wallet/deposit', 'WalletController@depositRequest')
	->name('wallet_deposit');

// Profile
Route::post('/profile/phone/update', 'ProfileController@updatePhone')
	->name('profile_phone_update');
Route::post('/profile/account/update', 'ProfileController@updateAccount')
	->name('profile_account_update');

// Discount Code
Route::get('/order/discount-code', 'OrderController@viewDiscountCodeList')
	->name('order_discount_code_list');
	

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
Route::post('/order/review', 'OrderController@review')
	->name('order_review');
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
	// Transaction
	Route::get('/mng/transaction/wallet', 'Mng\WalletController@viewTransactionList')
	->name('mng_wallet_transaction');
	
	// Wallet
	Route::post('/mng/wallet/{id}', 'Mng\WalletController@update')
		->name('mng_wallet_update');
	Route::post('/mng/wallet/{id}/hand', 'Mng\WalletController@updateHand')
		->name('mng_wallet_hand_update');
	Route::post('/mng/wallet/{id}/deposit', 'Mng\WalletController@deposit')
		->name('mng_wallet_deposit');
	
	Route::get('/mng/wallet/request', 'Mng\WalletController@viewRequestList')
		->name('mng_wallet_request');
	Route::post('/mng/wallet/request/{id}/deposit', 'Mng\WalletController@requestDeposit')
		->name('mng_wallet_request_deposit');
	Route::post('/mng/wallet/request/{id}/reject', 'Mng\WalletController@rejectDeposit')
		->name('mng_wallet_reject_deposit');
	
	// User
	Route::get('/mng/user', 'Mng\UserController@viewList')
		->name('mng_user_list');
	
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
	Route::get('/mng/pro/{id}/print','Mng\ProController@printTemp')
		->name('mng_pro_print');
	
	Route::post('/mng/pro/avatar', 'Mng\ProController@approveAvatar')
		->name('approve_pro_avatar');
	Route::post('/mng/pro/update_cv', 'Mng\ProController@updateCV')
		->name('update_pro_cv');
	Route::post('/mng/pro/active', 'Mng\ProController@active')
		->name('active_pro');
	
	// Company
	Route::get('/mng/company', 'Mng\CompanyController@viewList')
		->name('mng_company_list');
	Route::get('/mng/company/{id?}', 'Mng\CompanyController@view')
		->name('mng_company_page');
	Route::post('/mng/company/{id?}', 'Mng\CompanyController@modify')
		->name('modify_company');
	
	Route::get('/mng/accounts', 'Mng\AccountController@viewList')
		->name('mng_account_list_page');
	
	// Orders
	Route::get('/mng/orders', 'Mng\OrderController@viewList')
		->name('mng_order_list');
	Route::post('/mng/order/{orderNo}/cancel', 'Mng\OrderController@cancel')
		->name('mng_cancel_order');

	// Blog
	Route::get('/mng/blog', 'Mng\BlogController@viewList')
		->name('mng_blog_list');
	Route::get('/mng/blog/new', 'Mng\BlogController@newBlog')
		->name('mng_blog_new');
	Route::post('/mng/blog', 'Mng\BlogController@updateOrCreate')
		->name('mng_blog_create');
	Route::get('/mng/blog/{id}', 'Mng\BlogController@edit')
		->name('mng_blog_edit');
	Route::post('/mng/blog/{id}/update', 'Mng\BlogController@updateOrCreate')
		->name('mng_blog_update');
	Route::post('/mng/blog/{id}/delete', 'Mng\BlogController@delete')
		->name('mng_blog_delete');
	Route::post('/mng/blog/{id}/highlight', 'Mng\BlogController@highlight')
		->name('mng_blog_highlight');
	Route::post('/mng/blog/{id}/unhighlight', 'Mng\BlogController@unhighlight')
		->name('mng_blog_unhighlight');

	// Event
	Route::get('/mng/event', 'Mng\EventController@viewList')
		->name('mng_event_list');
	Route::post('/mng/event', 'Mng\EventController@create')
		->name('mng_event_create');
	Route::post('/mng/event/{id}/delete', 'Mng\EventController@delete')
		->name('mng_event_delete');
	
	// Video
	Route::get('/mng/video', 'Mng\VideoController@viewList')
		->name('mng_video_list');
	Route::get('/mng/video/new', 'Mng\VideoController@newVideo')
		->name('mng_video_new');

	// Service
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
	
	// Survey
	Route::get('/mng/service/{id}/survey', 'Mng\ServiceController@viewSurveyList')
		->name('mng_survey_list');
	Route::post('/mng/service/{id}/survey', 'Mng\ServiceController@createQuestion')
		->name('mng_survey_question_create');
	Route::get('/mng/survey/question/{id}', 'Mng\ServiceController@editQuestion')
		->name('mng_survey_question_edit');
	Route::post('/mng/survey/question/{id}/update', 'Mng\ServiceController@updateQuestion')
		->name('mng_survey_question_update');
	Route::post('/mng/survey/question/{id}/delete', 'Mng\ServiceController@deleteQuestion')
		->name('mng_survey_question_delete');
	Route::post('/mng/survey/question/{id}/answer', 'Mng\ServiceController@createAnswer')
		->name('mng_survey_answer_create');
	Route::get('/mng/survey/answer/{id}', 'Mng\ServiceController@editAnswer')
		->name('mng_survey_answer_edit');
	Route::post('/mng/survey/answer/{id}/update', 'Mng\ServiceController@updateAnswer')
		->name('mng_survey_answer_update');
	Route::post('/mng/survey/answer/{id}/delete', 'Mng\ServiceController@deleteAnswer')
		->name('mng_survey_answer_delete');

	// Common
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

	// PA
	Route::get('/mng/pa', 'Mng\PAController@viewList')
		->name('mng_pa_list');
	Route::post('/mng/pa', 'Mng\PAController@create')
		->name('mng_pa_create');
	Route::post('/mng/pa/{id}/delete', 'Mng\PAController@delete')
		->name('mng_pa_delete');
	
	// Export
	Route::get('/mng/exp/pro', 'Export\ExportController@proExport')
		->name('export_pro');
});
/** Management - END **/
// 	Route::get('/test', 'Export\ExportController@proExport');
	
// Route::get('/test2', function () { return view('mail.out-location'); });
// Route::get('/test3', function () { return view('test3'); });
