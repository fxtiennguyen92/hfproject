<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Survey;
use App\Service;
use App\ServiceHint;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
	public function getSurvey($id) {
		try {
			$survey = Survey::api_getByService($id);
			foreach ($survey as $question) {
				foreach ($question->answers as $key => $answer) {
					$answer->checked = ($key == 0);
					$answer->answer_text = '';
				}
			}
			
			if (sizeof($survey) > 0) {
				$service = Service::api_get($id);
				
				$res = array(
					'service' => $service,
					'survey' => $survey,
				);
				return response()->json($res, 200);
			}
			
			return response()->json('', 400);
		} catch (\Exception $e) {
			return response()->json($e->getMessage(), 500);
		}
	}

	public function getRootServices() {
		try {
			$rootServices = Service::api_getRootServices();
			$hints = ServiceHint::getPopular();
			
			$res = array($rootServices, $hints);
			return response()->json($res, 200);
		} catch (\Exception $e) {
			return response()->json($e->getMessage(), 500);
		}
	}

	public function getHints() {
		try {
			$hints = ServiceHint::getPopular();
			return response()->json($hints, 200);
		} catch (\Exception $e) {
			return response()->json($e->getMessage(), 500);
		}
	}

	public function get($id) {
		try {
			$service = Service::api_get($id);
			return response()->json($service, 200);
		} catch (\Exception $e) {
			return response()->json($e->getMessage(), 500);
		}
	}

	public function search(Request $request) {
		try {
			if (!$request->hint) {
				return response()->json('', 400);
			}
			
			$hints = explode(',', $request->hint);
			if (sizeof($hints) <= 0) {
				return response()->json('', 400);
			}
			
			$services = Service::api_getByHint($hints);
			return response()->json($services, 200);
		} catch (\Exception $e) {
			return response()->json($e->getMessage(), 500);
		}
	}
}
