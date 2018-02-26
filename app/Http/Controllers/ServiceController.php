<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Survey;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Request;
use App\Order;
use App\Common;
use App\Service;

class ServiceController extends Controller
{
	public function view($serviceUrlName, Request $request) {
		// redirect to login page if not member
		if (!auth()->check()) {
			return redirect()->route('login_page');
		}
		
		$surveyModel = new Survey();
		$commonModel = new Common();
		$serviceModel = new Service();
		
		$service = $serviceModel->getByIdOrUrlName($serviceUrlName);
		
		$questions = $surveyModel->getByService($service->id);
		if (sizeof($questions) == 0) {
			throw new NotFoundHttpException();
		}
		
		$cities = $commonModel->getCityList();
		$districts = null;
		if ($cities) {
			$districts = $commonModel->getDistList($cities->first()->code);
		}
		
		// put service to session
		$request->session()->put('service', $service->id);
		
		return view(Config::get('constants.SURVEY_PAGE'), array(
				'service' => $service,
				'questions' => $questions,
				'cities' => $cities,
				'districts' => $districts,
		));
	}

	public function submitOrder(Request $request) {
		// get service from session
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
		$common = new Common();
		$order->address = $request->address
			.', '.$common->getByCode($order->district)->name
			.', '.$common->getByCode($order->city)->name;
		
		$order->time_state = $request->time;
		if ($request->time == 1) {
			$estExcuteDate = CommonController::convertStringToDateTime(substr($request->estTime, -16));
			if ($estExcuteDate) {
				$order->est_excute_at = $estExcuteDate;
				$order->est_excute_at_string = $request->estTime;
			}
		}
		
		$order->save();
		response()->json('', 200);
	}
}
