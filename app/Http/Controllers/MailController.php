<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;

class MailController extends Controller
{
	public function sendVerifyMail($name, $email, $confirmCode) {
		Mail::send('mail.verify', array(
						'name' => $name,
						'confirm_code' => $confirmCode
		), function($message) use ($email) {
			$message->to($email)->subject(Config::get('constants.VERIFY_MAIL_SUBJECT'));
		});
	}
}
