<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Third Party Services
	|--------------------------------------------------------------------------
	|
	| This file is for storing the credentials for third party services such
	| as Stripe, Mailgun, SparkPost and others. This file provides a sane
	| default location for this type of information, allowing packages
	| to have a conventional place to find your various credentials.
	|
	*/

	'mailgun' => [
		'domain' => env('MAILGUN_DOMAIN'),
		'secret' => env('MAILGUN_SECRET'),
	],

	'ses' => [
		'key' => env('SES_KEY'),
		'secret' => env('SES_SECRET'),
		'region' => 'us-east-1',
	],

	'sparkpost' => [
		'secret' => env('SPARKPOST_SECRET'),
	],

	'stripe' => [
		'model' => App\User::class,
		'key' => env('STRIPE_KEY'),
		'secret' => env('STRIPE_SECRET'),
	],

	/** DEV **/
	'facebook' => [
		'client_id' => '136548870376149',
		'client_secret' => 'b714acc480f1ec447708013f0934ce98',
		'redirect' => 'http://localhost/hfproject/public/callback/facebook',
	],

	'google' => [
		'client_id' => '641434236169-r0jpcmvjlv0hhnenqrlfqtn6832l268i.apps.googleusercontent.com',
		'client_secret' => 'hOjLV9pEBtop_wy-yIfus72A',
		'redirect' => 'http://localhost/hfproject/public/callback/google'
	],

	/** SERVER **/
// 	'facebook' => [
// 		'client_id' => '1600106333380695',
// 		'client_secret' => '2b9c8d0a402672c30ab510890aa46b6e',
// 		'redirect' => 'http://hfproject.ap-southeast-1.elasticbeanstalk.com/callback/facebook',
// 	],
	
// 	'google' => [
// 		'client_id' => '641434236169-35kjhdis4s7uqnfat4karau2tp8echb0.apps.googleusercontent.com',
// 		'client_secret' => 'qSL-rCIbJ6eLTHaV5qS9B-iF',
// 		'redirect' => 'http://hfproject.ap-southeast-1.elasticbeanstalk.com/callback/google'
// 	],
];
