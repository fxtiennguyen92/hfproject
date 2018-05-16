<?php

namespace App\Http\Controllers\Mng;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Common;
use App\Company;
use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Material;
use App\Http\Controllers\FileController;

class CompanyController extends Controller
{
	protected function validator(array $data) {
		return Validator::make($data, [
						'name' => 'required|string|max:150',
						'address_1' => 'required|string|max:150',
						'address_2' => 'required|string|max:150',
						'email' => 'nullable|string|email|max:100|unique:companies',
						'phone_1' => 'nullable|string|max:25',
						'phone_2' => 'nullable|string|max:25',
		]);
	}

	public function viewList() {
		$compModel = new Company();
		$companies = $compModel->getAll();

		return view(Config::get('constants.MNG_COMPANY_LIST_PAGE'), array(
						'companies' => $companies,
		));
	}

	public function view($id = null) {
		$commonModel = new Common();
		$serviceModel = new Service();
		$compModel = new Company();
		
		$comp = null;
		$services = $serviceModel->getAll();
		$cities = $commonModel->getCityList();
		$districts = null;
		
		if ($id) {
			$comp = $compModel->get($id);
			$districts = $commonModel->getDistList($comp->city);
		} else {
			$districts = $commonModel->getDistList($cities->first()->code);
		}
		
		return view(Config::get('constants.MNG_COMPANY_PAGE'), array(
						'company' => $comp,
						'cities' => $cities,
						'districts' => $districts,
						'services' => $services
		));
	}

	public function newCompany(Request $request) {
		$commonModel = new Common();
		$serviceModel = new Service();
		$materialModel = new Material();
		
		$services = $serviceModel->getAll();
		$materials = $materialModel->getAll();
		
		$cities = $commonModel->getCityList();
		$cityCode = $cities->first()->code;
		
		$preAddress = null;
		if ($request->session()->has('preAddress')) {
			$preAddress = $request->session()->get('preAddress');
			$cityCode = $preAddress['city'];
		}
		
		$districts = $commonModel->getDistList($cityCode);
		
		return view(Config::get('constants.PA_COMPANY_PAGE'), array(
						'cities' => $cities,
						'districts' => $districts,
						'preAddress' => $preAddress,
						'services' => $services,
						'materials' => $materials
		));
	}
	
	public function viewList_PA() {
		$compModel = new Company();
		$companies = $compModel->getAll();
		
		return view(Config::get('constants.PA_COMPANY_LIST_PAGE'), array(
						'companies' => $companies,
		));
	}

	public function create(Request $request) {
		$validator = $this->validator($request->all());
		if ($validator->fails()) {
			return response()->json($validator->errors()->first(), 409);
		}
		
		// check exist phone
		$companyModel = new Company();
		if ($companyModel->existPhone($request->phone_1) || $companyModel->existPhone($request->phone_2)) {
			return response()->json('Phone is registered', 409);
		}
		
		// init style array
		$style = array(
						'style' => ($request->style) ? $request->style : array(),
						'service' => ($request->service) ? $request->service : array(),
						'material' => ($request->material) ? $request->material : array(),
						'service_name' => ($request->service) ? $this->getServiceNameArray($request->service) : array(),
						'material_name' => ($request->material) ? $this->getMaterialNameArray($request->material) : array(),
		);
		
		// create new service
		if ($request->otherMaterial) {
			$newMaterial = $this->getOtherMaterial($request->otherMaterial);
			
			if ($newMaterial) {
				array_push($style['material'], $newMaterial->id);
				array_push($style['material_name'], $newMaterial->name);
			}
		}
		
		// create new service
		if ($request->otherService) {
			$newService = $this->getOtherService($request->otherService);
			
			if ($newService) {
				array_push($style['service'], $newService->id);
				array_push($style['service_name'], $newService->name);
			}
		}
		
		// create company
		try {
			$comp = new Company();
			$comp->name = $request->name;
			$comp->address_1 = $request->address_1;
			$comp->address_2 = $request->address_2;
			$comp->district = $request->district;
			$comp->city = $request->city;
			$comp->email = $request->email;
			$comp->phone_1 = $request->phone_1;
			$comp->phone_2 = $request->phone_2;
			$comp->style= json_encode($style);
			$comp->description = $request->description;
			$comp->created_by = (auth()->check()) ? auth()->user()->id : null;
			
			// set image name
			$image = $request->image;
			$fileName = null;
			if ($image) {
				$fileName = str_random(6).'.png';
				$comp->image = $fileName;
			}
			
			// create company
			$comp->save();
			
			// save address into session
			$this->saveAddressForNextInput($request);
			
			// save image
			if ($image) {
				$baseToPhp = explode(',', $image); // remove the "data:image/png;base64,"
				if (sizeof($baseToPhp) == 2) {
					$data = base64_decode($baseToPhp[1]);
					FileController::saveCompanyCoverImage($data, $fileName);
				}
			}
			
			return response()->json('', 200);
		} catch(\Exception $e) {
			return response()->json($e->getMessage(), 500);
		}
	}

	public function modify($id = null, Request $request) {
		$validator = $this->validator($request->all());
		if ($validator->fails()) {
			return response()->json($validator->errors()->first(), 409);
		}
		
		// check exist phone
		$companyModel = new Company();
		if ($companyModel->existPhone($request->phone_1, $id) || $companyModel->existPhone($request->phone_2, $id)) {
			return response()->json('Phone is registered', 409);
		}
		
		// init style array
		$style = array(
			'style' => ($request->style) ? $request->style : array(),
			'service' => ($request->service) ? $request->service : array(),
			'material' => ($request->material) ? $request->material : array(),
			'service_name' => ($request->service) ? $this->getServiceNameArray($request->service) : array(),
			'material_name' => ($request->material) ? $this->getMaterialNameArray($request->material) : array(),
		);
		
		// create new service
		if ($request->otherMaterial) {
			$newMaterial = $this->getOtherMaterial($request->otherMaterial);
			
			if ($newMaterial) {
				array_push($style['material'], $newMaterial->id);
				array_push($style['material_name'], $newMaterial->name);
			}
		}
		
		// create new service
		if ($request->otherService) {
			$newService = $this->getOtherService($request->otherService);
			
			if ($newService) {
				array_push($style['service'], $newService->id);
				array_push($style['service_name'], $newService->name);
			}
		}
		
		// update
		if ($id) {
			try {
				$comp = $companyModel->get($id);
				if (!$comp) {
					return response()->json('', 400);
				}
				
				$comp->name = $request->name;
				$comp->address_1 = $request->address_1;
				$comp->address_2 = $request->address_2;
				$comp->district = $request->district;
				$comp->city = $request->city;
				$comp->email = $request->email;
				$comp->phone_1 = $request->phone_1;
				$comp->phone_2 = $request->phone_2;
				$comp->style = json_encode($style);
				if (auth()->check()) {
					$comp->updated_by = auth()->user()->id;
				}
				$comp->save();
				
				return response()->json('', 200);
			} catch(\Exception $e) {
				return response()->json($e->getMessage(), 500);
			}
		}
		
		// add
		try {
			$comp = new Company();
			$comp->name = $request->name;
			$comp->address_1 = $request->address_1;
			$comp->address_2 = $request->address_2;
			$comp->district = $request->district;
			$comp->city = $request->city;
			$comp->email = $request->email;
			$comp->phone_1 = $request->phone_1;
			$comp->phone_2 = $request->phone_2;
			$comp->style= json_encode($style);
			$comp->description = $request->description;
			if (auth()->check()) {
				$comp->created_by = auth()->user()->id;
			}
			
			// set image name
			$image = $request->image;
			$fileName = null;
			if ($image) {
				$fileName = str_random(6).'.png';
				$comp->image = $fileName;
			}
			
			// create company
			$comp->save();
			
			// save address into session
			$this->saveAddressForNextInput($request);
			
			// save image
			if ($image) {
				$baseToPhp = explode(',', $image); // remove the "data:image/png;base64,"
				if (sizeof($baseToPhp) == 2) {
					$data = base64_decode($baseToPhp[1]);
					FileController::saveCompanyCoverImage($data, $fileName);
				}
			}
			
			return response()->json('', 200);
		} catch(\Exception $e) {
			return response()->json($e->getMessage(), 500);
		}
	}

	/**
	 * Save previous company address into session.
	 * 
	 * @param unknown $request
	 */
	private function saveAddressForNextInput($request) {
		if (!auth()->check()) {
			return;
		}
		
		$preAddress = array(
			'address_1' => $request->address_1,
			'address_2' => $request->address_2,
			'district' => $request->district,
			'city' => $request->city,
		);
		
		$request->session()->put('preAddress', $preAddress);
	}

	/**
	 * Get name array from id array
	 * 
	 * @param unknown $arrMaterialId
	 * @return array
	 */
	private function getMaterialNameArray($arrMaterialId) {
		$arrMaterialName = array();
		$materialModel = new Material();
		foreach ($arrMaterialId as $id) {
			$material = $materialModel->get($id);
			if ($material) {
				array_push($arrMaterialName, $material->name);
			}
		}
		
		return $arrMaterialName;
	}

	/**
	 * Get name array from id array
	 *
	 * @param unknown $arrServiceId
	 * @return array
	 */
	private function getServiceNameArray($arrServiceId) {
		$arrServiceName = array();
		$serviceModel = new Service();
		foreach ($arrServiceId as $id) {
			$service = $serviceModel->get($id);
			if ($service) {
				array_push($arrServiceName, $service->name);
			}
		}
		
		return $arrServiceName;
	}

	/**
	 * Save new material from other material input.
	 * 
	 * @param unknown $newMaterial
	 * @return NULL|unknown
	 */
	private function getOtherMaterial($newMaterial) {
		if (!$newMaterial) {
			return null;
		}
		
		try {
			$material = new Material();
			$material->name = $newMaterial;
			$material->created_by = (auth()->check()) ? auth()->user()->id : null;
			
			$material->save();
			return $material;
		} catch(\Exception $e) {
			return null;
		}
	}

	/**
	 * Save new service from other service input.
	 * 
	 * @param unknown $newService
	 * @return NULL|unknown
	 */
	private function getOtherService($newService) {
		if (!$newService) {
			return null;
		}
		
		try {
			$service = new Service();
			$service->name = $newService;
			$service->created_by = (auth()->check()) ? auth()->user()->id : null;
			
			$service->save();
			return $service;
		} catch(\Exception $e) {
			return null;
		}
	}
}
