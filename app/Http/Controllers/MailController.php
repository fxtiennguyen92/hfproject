<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;

class MailController extends Controller
{
	public static function sendVerifyMail($name, $email, $confirmCode) {
		Mail::send('mail.verify', array(
						'name' => $name,
						'confirmCode' => $confirmCode
		), function($message) use ($email) {
			$message->to($email)->subject(Config::get('constants.VERIFY_MAIL_SUBJECT'));
		});
	}

	public static function sendActiveProAccountMail($name, $email, $password) {
		Mail::send('mail.active', array(
						'name' => $name,
						'email' => $email,
						'password' => $password
		), function($message) use ($email) {
			$message->to($email)->subject(Config::get('constants.ACTIVE_PRO_ACCOUNT_MAIL_SUBJECT'));
		});
	}

	public static function sendAccountInfoMail($name, $phone, $email, $password) {
		Mail::send('mail.account', array(
						'name' => $name,
						'phone' => $phone,
						'email' => $email,
						'password' => $password
		), function($message) use ($email) {
			$message->to($email)->subject(Config::get('constants.ACCOUNT_INFO_MAIL_SUBJECT'));
		});
	}

	public static function sendOrderInfoMail($email, $order) {
		Mail::send('mail.order', array(
						'email' => $email,
						'order' => $order
		), function($message) use ($email) {
			$message->to($email)->subject(Config::get('constants.ORDER_INFO_MAIL_SUBJECT'));
		});
	}

// 	public function sendOutLocationMail($address = '대한민국 서울특별시 서초구 서초동 1327-3', $email = 'thezero00@naver.com') {
// 		Mail::send('mail.out-location', array(
// 						'address' => $address,
// 		), function($message) use ($email) {
// 			$message->to($email)->subject(Config::get('constants.OUT_LOCATION_MAIL_SUBJECT'));
// 		});
// 	}
	
	public function outlocation() {
		$this->sendOutLocationMail();
	}
}
