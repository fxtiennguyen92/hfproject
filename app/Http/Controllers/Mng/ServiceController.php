<?php

namespace App\Http\Controllers\Mng;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Doc;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Service;
use App\Http\Controllers\FileController;

class ServiceController extends Controller
{
	protected function validator(array $data) {
		return Validator::make($data, [
						'name' => 'required|string|max:50',
						'url_name' => 'required|string|max:50',
		]);
	}

	public function viewList(Request $request) {
		$serviceModel = new Service();
		$services = $serviceModel->getAllRootsForMng();
		
		return view(Config::get('constants.MNG_SERVICE_LIST_PAGE'), array(
						'services' => $services,
		));
	}

	public function newService(Request $request) {
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

	public function edit($id, Request $request) {
		$serviceModel = new Service();
		$service = $serviceModel->getByIdForMng($id);
		if (!$service) {
			$request->session()->forget('service');
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
}
