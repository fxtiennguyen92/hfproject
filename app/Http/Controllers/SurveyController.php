<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Survey;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Request;
use App\Order;
use App\Common;

class SurveyController extends Controller
{
	public function view($serviceId, Request $request) {
		$surveyModel = new Survey();
		$commonModel = new Common();
		
		$questions = $surveyModel->getByService($serviceId);
		if (!count($questions)) {
			throw new NotFoundHttpException();
		}
		
		$cities = $commonModel->getCityList();
		
		// put service to session
		$request->session()->put('service', $serviceId);
		
		return view(Config::get('constants.SURVEY_PAGE'), array(
				'questions' => $questions,
				'cities' => $cities,
		));
	}

	public function submitOrderDetails(Request $request) {
		// session
		if (!$request->session()->has('service')) {
			response()->json('', 400);
		}
		$serviceId = $request->session()->get('service');
		
		// get survey info
		$survey = new Survey();
		$requirements = array();
		$short_requirements = array();
		foreach ($request->q as $qId => $a) {
			// get question info
			$question = $survey->getByQuestion($qId);
			
			// set answers
			$answers = '';
			if ($question->answer_type == Config::get('constants.ANS_CHKBOX')) { // checkbox
				$answers = array();
				foreach ($a as $aId) {
					$ans = '';
					$i = $aId - 1;
					if ($question->answers[$i]->init_flg == Config::get('constants.INIT_OTHER')) {
						$inp = $qId.'_'.$aId.'_text';
						$ans = $request->$inp;
					} else {
						$ans= $question->answers[$i]->content;
					}
					
					$answers[] = $ans;
					$short_requirements[] = $ans;
				}
			} else if ($question->answer_type == Config::get('constants.ANS_RADBTN')) { // radio button
				$answers = $question->answers[$a - 1]->content;
				$short_requirements[] = $answers;
			} else { // text
				$answers = $a;
				$short_requirements[] = $answers;
			}
			
			$requirements[] = [
				'q_i' => $qId,
				'q_c' => $question->short_content,
				'a_i' => $a,
				'a_c' => $answers
			];
		}
		
		$order = new Order();
		$order->user_id = auth()->user()->id;
		$order->user_name = auth()->user()->name;
		$order->user_email = auth()->user()->email;
		$order->user_phone = auth()->user()->phone;
		$order->service_id = $serviceId;
		$order->requirements = json_encode($requirements);
		$order->short_requirements = implode(', ', $short_requirements);
		$order->address = $request->address;
		$order->city = $request->city;
		$order->district = $request->dist;
		$order->time_state = $request->time;
		if ($request->time == 2) {
			$estExcuteDate = CommonController::convertStringToDateTime(substr($request->estTime, -16));
			if ($estExcuteDate) {
				$order->est_excute_at = $estExcuteDate;
				$order->est_excute_at_string = $request->estTime;
			}
		}
		
		$order->save();
		response()->json('', 200);
	}
	
	public function complete() {
		return view(Config::get('constants.COMPLETE_PAGE'));
	}
// 	public function getLocation(Request $request) {
// 		$latitude = trim($request->latitude);
// 		$longitude = trim($request->longitude);
		
// 		$url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.$latitude.','.$longitude.'&sensor=false';
// 		$json = @file_get_contents($url);
// 		$data = json_decode($json);
// 		$status = $data->status;
// 		if ($status == 'OK'){
// 			//Get address from json data
// 			$location = $data->results[0]->formatted_address;
// 		} else {
// 			$location =  '';
// 		}
// 		//Print address
// 		echo $location;
// 	}
}
