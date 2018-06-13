<?php

namespace App\Http\Controllers\Mng;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Service;
use App\Http\Controllers\FileController;
use App\Survey;
use App\SurveyAnswer;

class ServiceController extends Controller
{
	protected function validator(array $data) {
		return Validator::make($data, [
						'name' => 'required|string|max:50',
						'url_name' => 'required|string|max:50',
		]);
	}

	protected function question_validator(array $data) {
		return Validator::make($data, [
						'content' => 'required|string|max:225',
						'short_content' => 'required|string|max:150',
						'order_dsp' => 'required|integer',
		]);
	}

	protected function answer_validator(array $data) {
		return Validator::make($data, [
						'content' => 'required|string|max:225',
						'order_dsp' => 'required|integer',
		]);
	}

	public function viewList() {
		$serviceModel = new Service();
		$services = $serviceModel->getAllRootsForMng();
		
		return view(Config::get('constants.MNG_SERVICE_LIST_PAGE'), array(
						'services' => $services,
		));
	}

	public function viewSurveyList($id) {
		$serviceModel = new Service();
		$surveyModel = new Survey();
		
		$service = $serviceModel->getByIdForMng($id);
		$survey = $surveyModel->getByService($id);
		
		return view(Config::get('constants.MNG_SURVEY_PAGE'), array(
						'service' => $service,
						'survey' => $survey,
		));
	}

	public function newService() {
		$serviceModel = new Service();
		$roots = $serviceModel->getAllRootsForMng();
		
		return view(Config::get('constants.MNG_SERVICE_PAGE'), array(
						'roots' => $roots,
		));
	}

	public function create(Request $request) {
		$validator = $this->validator($request->all());
		if ($validator->fails()) {
			return Redirect::back()->withInput()->with('error', $validator->errors()->first());
		}
		
		try {
			$service = new Service();
			
			$service->name = $request->name;
			$service->url_name = $request->url_name;
			$service->parent_id = $request->style;
			$service->css = $request->css;
			$service->hint = $request->hint;
			$service->updated_by = auth()->user()->id;
			
			$service->save();
			
			if ($request->image) {
				$image = $request->image;
				$baseToPhp = explode(',', $image); // remove the "data:image/png;base64,"
				if (sizeof($baseToPhp) == 2) {
					$data = base64_decode($baseToPhp[1]);
					FileController::saveServiceImage($data, $service->id);
				}
			}
			
			return redirect()->route('mng_service_list');
		} catch (\Exception $e) {
			return Redirect::back()->withInput()->with('error', $e->getMessage());
		}
	}

	public function edit($id) {
		$serviceModel = new Service();
		$service = $serviceModel->getByIdForMng($id);
		if (!$service) {
			throw new NotFoundHttpException();
		}
		
		$roots = $serviceModel->getAllRootsForMng();
		return view(Config::get('constants.MNG_SERVICE_PAGE'), array(
						'roots' => $roots,
						'service' => $service
		));
	}

	public function update($id, Request $request) {
		$validator = $this->validator($request->all());
		if ($validator->fails()) {
			return Redirect::back()->withInput()->with('error', $validator->errors()->first());
		}
		
		try {
			$service = Service::find($id);
			
			$service->name = $request->name;
			$service->url_name = $request->url_name;
			$service->parent_id = $request->style;
			$service->css = $request->css;
			$service->hint = $request->hint;
			$service->updated_by = auth()->user()->id;
			
			$service->save();
			
			if ($request->image) {
				$image = $request->image;
				$baseToPhp = explode(',', $image); // remove the "data:image/png;base64,"
				if (sizeof($baseToPhp) == 2) {
					$data = base64_decode($baseToPhp[1]);
					FileController::saveServiceImage($data, $service->id);
				}
			}
			
			return redirect()->route('mng_service_list');
		} catch (\Exception $e) {
			return Redirect::back()->withInput()->with('error', $e->getMessage());
		}
	}

	public function delete($id) {
		try {
			$serviceModel = new Service();
			$serviceModel->updateDeleteFlg($id, Config::get('constants.FLG_ON'), auth()->user()->id);
			
			$service = $serviceModel->getByIdForMng($id);
			
			if ($service->parent_id == Config::get('constants.SERVICE_ROOT')) {
				$serviceModel->updateDeleteFlgByParentId($service->id, Config::get('constants.FLG_ON'), auth()->user()->id);
			}
			
			return redirect()->route('mng_service_list');
		} catch (\Exception $e) {
			return Redirect::back()->withInput()->with('error', $e->getMessage());
		}
	}

	public function active($id) {
		try {
			$serviceModel = new Service();
			$serviceModel->updateDeleteFlg($id, Config::get('constants.FLG_OFF'), auth()->user()->id);
			
			return redirect()->route('mng_service_list');
		} catch (\Exception $e) {
			return Redirect::back()->withInput()->with('error', $e->getMessage());
		}
	}

	public function publish($id) {
		try {
			$serviceModel = new Service();
			$serviceModel->updateServeFlg($id, Config::get('constants.FLG_ON'), auth()->user()->id);
			
			$service = $serviceModel->getByIdForMng($id);
			
			if ($service->parent_id == Config::get('constants.SERVICE_ROOT')) {
				$serviceModel->updateServeFlgByParentId($service->id, Config::get('constants.FLG_ON'), auth()->user()->id);
			}
			
			return redirect()->route('mng_service_list');
		} catch (\Exception $e) {
			return Redirect::back()->withInput()->with('error', $e->getMessage());
		}
	}

	public function unpublish($id) {
		try {
			$serviceModel = new Service();
			$serviceModel->updateServeFlg($id, Config::get('constants.FLG_OFF'), auth()->user()->id);
			
			return redirect()->route('mng_service_list');
		} catch (\Exception $e) {
			return Redirect::back()->withInput()->with('error', $e->getMessage());
		}
	}

	public function popular($id) {
		try {
			$serviceModel = new Service();
			$serviceModel->updatePopularFlg($id, Config::get('constants.FLG_ON'), auth()->user()->id);
			
			return redirect()->route('mng_service_list');
		} catch (\Exception $e) {
			return Redirect::back()->withInput()->with('error', $e->getMessage());
		}
	}

	public function unpopular($id) {
		try {
			$serviceModel = new Service();
			$serviceModel->updatePopularFlg($id, Config::get('constants.FLG_OFF'), auth()->user()->id);
			
			return redirect()->route('mng_service_list');
		} catch (\Exception $e) {
			return Redirect::back()->withInput()->with('error', $e->getMessage());
		}
	}

	/** Question **/

	public function createQuestion($id, Request $request) {
		$validator = $this->question_validator($request->all());
		if ($validator->fails()) {
			return response()->json($validator->errors()->first(), 400);
		}
		
		try {
			$survey = new Survey();
			$survey->service_id = $id;
			$survey->content = $request->content;
			$survey->short_content = $request->short_content;
			$survey->order_dsp = $request->order_dsp;
			$survey->answer_type = $request->answer_type;
			$survey->updated_by = auth()->user()->id;
			$survey->save();
		
			return response()->json('', 200);
		} catch (\Exception $e) {
			return response()->json($e->getMessage(), 400);
		}
	}

	public function editQuestion($id) {
		$surveyModel = new Survey();
		$survey = $surveyModel->getById($id);
		
		if ($survey) {
			return response()->json($survey, 200);
		}
		return response()->json('', 400);
	}

	public function updateQuestion($id, Request $request) {
		$validator = $this->question_validator($request->all());
		if ($validator->fails()) {
			return response()->json($validator->errors()->first(), 400);
		}
		
		try {
			$survey = Survey::find($id);
			$survey->content = $request->content;
			$survey->short_content = $request->short_content;
			$survey->order_dsp = $request->order_dsp;
			$survey->answer_type = $request->answer_type;
			$survey->updated_by = auth()->user()->id;
			$survey->save();
			
			return response()->json('', 200);
		} catch (\Exception $e) {
			return response()->json($e->getMessage(), 400);
		}
	}

	public function deleteQuestion($id) {
		try {
			Survey::destroy($id);
			SurveyAnswer::where('question_id', $id)->delete();
			
			return response()->json('', 200);
		} catch (\Exception $e) {
			return response()->json($e->getMessage(), 400);
		}
	}

	/** Answer ** */

	public function createAnswer($id, Request $request) {
		$validator = $this->answer_validator($request->all());
		if ($validator->fails()) {
			return response()->json($validator->errors()->first(), 400);
		}
		
		try {
			$answer = new SurveyAnswer();
			$answer->question_id = $id;
			$answer->content = $request->content;
			$answer->order_dsp = $request->order_dsp;
			$answer->other_flg = $request->other_flg;
			$answer->updated_by = auth()->user()->id;
			$answer->save();
			
			return response()->json('', 200);
		} catch (\Exception $e) {
			return response()->json($e->getMessage(), 400);
		}
	}

	public function editAnswer($id) {
		$answerModel = new SurveyAnswer();
		$answer = $answerModel->getById($id);
		
		if ($answer) {
			return response()->json($answer, 200);
		}
		return response()->json('', 400);
	}

	public function updateAnswer($id, Request $request) {
		$validator = $this->answer_validator($request->all());
		if ($validator->fails()) {
			return response()->json($validator->errors()->first(), 400);
		}
		
		try {
			$answer = SurveyAnswer::find($id);
			$answer->content = $request->content;
			$answer->order_dsp = $request->order_dsp;
			$answer->other_flg = $request->other_flg;
			$answer->updated_by = auth()->user()->id;
			$answer->save();
			
			return response()->json('', 200);
		} catch (\Exception $e) {
			return response()->json($e->getMessage(), 400);
		}
	}

	public function deleteAnswer($id) {
		try {
			SurveyAnswer::destroy($id);
			
			return response()->json('', 200);
		} catch (\Exception $e) {
			return response()->json($e->getMessage(), 400);
		}
	}
}
