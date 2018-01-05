<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Survey;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Request;

class SurveyController extends Controller
{
	public function view($serviceId) {
		$survey = new Survey();
		$questions = $survey->getByService($serviceId);
		
		if (!count($questions)) {
			throw new NotFoundHttpException();
		}
		
		return view(Config::get('constants.SURVEY_PAGE'), array(
				'serviceId' => $serviceId,
				'questions' => $questions
		));
	}

	public function submitOrderDetails(Request $request) {
		dd($request->all());
	}
}
