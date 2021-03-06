<?php

namespace App\Http\Controllers;

use App\Common;
use Illuminate\Http\Request;
use App\Company;

class CommonController
{
	public static function convertStringToDate($string) {
		if ($string) {
			return \DateTime::createFromFormat('d/m/Y', $string);
		}
		
		return null;
	}
	
	public static function convertStringToDateTime($string) {
		if ($string) {
			return \DateTime::createFromFormat('d/m/Y H:i', $string);
		}
		
		return null;
	}
	
	public function getDistByCity($code) {
		$model = new Common();
		return $model->getDistList($code);
	}

	public function getCompanies(Request $request) {
		$term = $request->get('term','');
		$comp = new Company();
		$companies = $comp->autocompleteByName($term);
		
		$results = array();
		foreach ($companies as $company) {
			$results[] = ['id' => $company->id,'value' => $company->name, 'address' => $company->address];
		}
		
		return response()->json($results, 200);
	}

	public function addCompany(Request $request) {
		$comp = new Company();
		$comp->name = $request->name;
		$comp->address = $request->address;
		
		$comp->save;
		return response()->json('', 200);
	}

	public static function getNext2Days() {
		$dates = array();
		for ($i = 0; $i <= 1; $i++) {
			$weekday = '';
			$date = date('d/m/Y', strtotime('today + '.$i.' day'));
			$weekday = CommonController::translateWeekday(date('l', strtotime('today + '.$i.' day')));
			array_push($dates, $weekday.', '.$date);
		}
		
		return $dates;
	}
	
	public static function getNext7Days() {
		$dates = array();
		for ($i = 0; $i <= 6; $i++) {
			$weekday = '';
			$date = date('d/m/Y', strtotime('today + '.$i.' day'));
			$weekday = CommonController::translateWeekday(date('l', strtotime('today + '.$i.' day')));
			array_push($dates, $weekday.', '.$date);
		}
		
		return $dates;
	}

	public static function getStringAsapExcuteDateTime() {
		$date = date('d/m/Y H:i', strtotime('+'.env('ASAP_EXCUTE_DATE').'minutes'));
		$weekday = CommonController::translateWeekday(date('l', strtotime('+'.env('ASAP_EXCUTE_DATE').'minutes')));
		
		return $weekday.', '.$date;
	}

	public static function getAllTimes() {
		$times = array();
		for ($i = 0; $i < 24; $i++) {
			array_push($times, sprintf('%02d', $i).':00');
			array_push($times, sprintf('%02d', $i).':30');
		}
		
		return $times;
	}

	public static function getOrderNo($order) {
		return $order->created_at->format('ymd').strtoupper(str_random(2)).$order->id;
	}

	public static function convertDatetimeFromApp($str) {
		return \DateTime::createFromFormat('Y-m-d\TH:i:s.uP', $str)
			->setTimeZone(new \DateTimeZone('Asia/Bangkok'))
			->format('Y-m-d H:i');
	}

	private static function translateWeekday($en) {
		switch ($en) {
			case 'Monday':
				$vi = 'Thứ hai';
				break;
			case 'Tuesday':
				$vi = 'Thứ ba';
				break;
			case 'Wednesday':
				$vi = 'Thứ tư';
				break;
			case 'Thursday':
				$vi = 'Thứ năm';
				break;
			case 'Friday':
				$vi = 'Thứ sáu';
				break;
			case 'Saturday':
				$vi = 'Thứ bảy';
				break;
			default:
				$vi = 'Chủ nhật';
				break;
		}
		
		return $vi;
	}
}
