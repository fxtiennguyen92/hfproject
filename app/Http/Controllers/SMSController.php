<?php

namespace App\Http\Controllers;

use App\Log;
use Illuminate\Support\Facades\Config;

class SMSController extends Controller
{
	public function test() {
		$this->sendActiveProAccountSMS('01648427815', 'G7W0VuUfgd5M');
	}
	
	public function sendActiveProAccountSMS($phone, $password) {
// 		$content = 'Tai khoan cua ban da duoc kich hoat. Mat khau cua ban la '.$password;
		$content = 'test';
		$this->sendSMS($phone, $content);
	}
	
	private function sendSMS($phone, $content, $smsType = 2, $brandName = 'HANDFREE') {
		$apiKey = env('SMS_API_KEY');
		$secretKey = env('SMS_SECRECT_KEY');
		
		$sendContent = urlencode($content);
		$data = "http://rest.esms.vn/MainService.svc/json/SendMultipleMessage_V4_get?Phone=$phone&Content=$sendContent&ApiKey=$apiKey&SecretKey=$secretKey&Brandname=$brandName&SmsType=$smsType";
		
		dd($data);
		
		$curl = curl_init($data);
		curl_setopt($curl, CURLOPT_FAILONERROR, true);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$textResult = curl_exec($curl);
		
		dd($textResult);
		
		
		$result = json_decode($textResult, true);
		if ($result['CodeResult'] == 100) {
			return;
		}
		
		// save error logs
		$log = new Log();
		$log->id = str_random(6);
		$log->type = Config::get('constants.LOG_SMS_KEY');
		$log->content = $textResult;
		
		$log->save();
	}
}
