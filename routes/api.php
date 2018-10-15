<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/test', 'API\UserController@test');

Route::post('/user/login', 'API\UserController@userLogin');
Route::post('/user/login/fb', 'API\UserController@userLoginByFacebook');
Route::post('/user/login/gg', 'API\UserController@userLoginByGoogle');

Route::post('/user/register', 'API\UserController@userRegister');
Route::post('/user/register/check', 'API\UserController@userCheckRegisterInfo');

Route::post('/user/sac', 'API\SACController@getByPhone');
Route::post('/user/sac/verify', 'API\SACController@verify');

Route::group(['middleware' => 'jwt.auth'], function () {
	Route::get('/user/services', 'API\ServiceController@getRootServices');
	Route::get('/user/services/search', 'API\ServiceController@search');
	
	Route::get('/user/service/{id}', 'API\ServiceController@get');
	Route::get('/user/service/{id}/services', 'API\ServiceController@getChildServices');
	Route::get('/user/service/{id}/survey', 'API\ServiceController@getSurvey');
	
	Route::get('/user/orders', 'API\OrderController@userGetAll');
	
	Route::post('/user/order', 'API\OrderController@create');
	Route::get('/user/order/{id}/quoted', 'API\OrderController@userGetQuotedPrice');
	
	Route::get('/user/order/{id}/pro/{proId}/accept', 'API\OrderController@userAcceptQuotedPrice');
	
});

Route::get('/user/services', 'API\ServiceController@getRootServices');
Route::get('/user/services/search', 'API\ServiceController@search');

Route::get('/user/service/{id}', 'API\ServiceController@get');
Route::get('/user/service/{id}/services', 'API\ServiceController@getChildServices');
Route::get('/user/service/{id}/survey', 'API\ServiceController@getSurvey');
	

Route::post('/user/order', 'API\OrderController@create');
Route::get('/user/orders', 'API\OrderController@userGetAll');
Route::get('/user/order/{id}/quoted', 'API\OrderController@userGetQuotedPrice');
Route::get('/user/order/{id}/pro/{proId}/accept', 'API\OrderController@userAcceptQuotedPrice');

Route::get('/user/order/{id}', 'API\OrderController@userGetOrder');
Route::get('/user/order/{id}/cancel', 'API\OrderController@userCancel');
Route::get('/user/order/{id}/rate', 'API\OrderController@userRate');

Route::get('/user/pro/{id}', 'API\ProController@getBasicInfo');

Route::get('/user/blogs', 'API\BlogController@viewList');
Route::get('/user/blogs/categories', 'API\BlogController@viewCategoryList');
Route::get('/user/blog/{url}', 'API\BlogController@view');


Route::get('/sys/noti/user/order/new', 'API\NotificationController@sendNewOrderNotification');