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
	public function __construct() {
		$this->getServiceHint();
	}

	public function search(Request $request) {
		if (!$request->hint) {
			return redirect()->route('home_page');
		}
		
		$serviceModel = new Service();
		$roots = $serviceModel->getAllServingRoots();
		$popularServices = $serviceModel->getMostPopular();
		
		$services = $serviceModel->getByHint($request->hint);
		
		return view(Config::get('constants.SERVICE_PAGE'), array(
						'services' => $services,
						'roots' => $roots,
						'popularServices' => $popularServices,
		));
	}

	public function view($urlName, Request $request) {
		$serviceModel = new Service();
		$service = $serviceModel->getByIdOrUrlName($urlName);
		if (!$service) {
			throw new NotFoundHttpException();
		}
		
		
		// service root => view service page
		if ($service->parent_id == Config::get('constants.SERVICE_ROOT')) {
			$roots = $serviceModel->getAllServingRoots();
			$popularServices = $serviceModel->getMostPopular();
			$services = $serviceModel->getServingChildrenByRoot($service->id);
			
			return view(Config::get('constants.SERVICE_PAGE'), array(
							'services' => $services,
							'roots' => $roots,
							'serviceRoot' => $service,
							'popularServices' => $popularServices,
			));
		}
		
		// service child => view survey page
		
	}

	public function viewSurvey($serviceUrlName, Request $request) {
		// redirect to login page if not member
		if (!auth()->check()) {
			$request->session()->put('back_service', $serviceUrlName);
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
		
		$dates = CommonController::getNext7Days();
		$times = CommonController::getAllTimes();
		
		// put service to session
		$request->session()->put('service', $service->id);
		
		$page = new \stdClass();
		$page->name = 'Đơn hàng';
		$page->back_route = 'home_page';
		
		return view(Config::get('constants.SURVEY_PAGE'), array(
				'page' => $page,
				'service' => $service,
				'questions' => $questions,
				'cities' => $cities,
				'districts' => $districts,
				'dates' => $dates,
				'times' => $times
		));
	}

	public function submit(Request $request) {
		// get service from session
		if (!$request->session()->has('service')) {
			return response()->json('', 400);
		}
		$serviceId = $request->session()->get('service');
		
		// check excute datetime
		$estExcuteDateString = null;
		$estExcuteDate = null;
		if ($request->timeState == 1) {
			$estExcuteDateString = $request->estDate.' '.$request->estTime;
			if (strlen($estExcuteDateString) < 16) {
				return response()->json('', 403);
			}
			
			$currDate = new \DateTime('now');
			$estExcuteDate = CommonController::convertStringToDateTime(substr($estExcuteDateString, -16));
			if ($estExcuteDate === null || $estExcuteDate <= $currDate) {
				return response()->json('', 403);
			}
		}
		
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
		$order->location = $request->location;
		
		$order->time_state = $request->timeState;
		$order->est_excute_at = $estExcuteDate;
		$order->est_excute_at_string = $estExcuteDateString;
		
		$order->save();
		Order::setOrderNo($order->id, CommonController::getOrderNo($order));
		
		$request->session()->put('order', $order->id);
		return response()->json($order->id, 200);
	}
}
