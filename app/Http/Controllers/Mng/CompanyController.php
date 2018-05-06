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

class CompanyController extends Controller
{
	protected function validator(array $data) {
		return Validator::make($data, [
						'name' => 'required|string|max:150',
						'address' => 'string|max:150',
						'email' => 'string|email|max:100',
						'phone_1' => 'string|max:50',
						'phone_2' => 'string|max:50',
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

	public function newCompany() {
		$commonModel = new Common();
		$serviceModel = new Service();
		$materialModel = new Material();
		
		$services = $serviceModel->getAll();
		$materials = $materialModel->getAll();
		
		$cities = $commonModel->getCityList();
		$districts = $commonModel->getDistList($cities->first()->code);
		
		return view('mng.company-new', array(
						'cities' => $cities,
						'districts' => $districts,
						'services' => $services,
						'materials' => $materials
		));
	}

	public function modify($id = null, Request $request) {
		$validator = $this->validator($request->all());
		if ($validator->fails()) {
			return response()->json('', 409);
		}
		
		$style = array(
			'style' => $request->style,
			'service' => $request->service,
			'material' => $request->material,
		);
		
		// update
		if ($id) {
			try {
				$model = new Company();
				$comp = $model->get($id);
				if (!$comp) {
					return response()->json('', 400);
				}
				
				$comp->name = $request->name;
				$comp->address = $request->address;
				$comp->district = $request->dist;
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
			$comp->address = $request->address;
			$comp->district = $request->dist;
			$comp->city = $request->city;
			$comp->email = $request->email;
			$comp->phone_1 = $request->phone_1;
			$comp->phone_2 = $request->phone_2;
			$comp->style= json_encode($style);
			if (auth()->check()) {
				$comp->created_by = auth()->user()->id;
			}
			$comp->save();
			
			return response()->json('', 200);
		} catch(\Exception $e) {
			return response()->json($e->getMessage(), 500);
		}
	}
}
