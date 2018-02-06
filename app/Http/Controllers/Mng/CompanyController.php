<?php

namespace App\Http\Controllers\Mng;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Common;
use App\Company;
use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
	protected function validator(array $data) {
		return Validator::make($data, [
						'name' => 'required|string|max:150',
						'address' => 'string|max:150',
						'email' => 'string|email|max:100',
						'phone' => 'string|max:50',
		]);
	}

	public function viewList() {
		$compModel = new Company();
		$companies = $compModel->getAll();

		return view(Config::get('constants.COMPANY_LIST_PAGE'), array(
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
		
		return view(Config::get('constants.COMPANY_PAGE'), array(
						'company' => $comp,
						'cities' => $cities,
						'districts' => $districts,
						'services' => $services
		));
	}

	public function modify($id = null, Request $request) {
		$validator = $this->validator($request->all());
		if ($validator->fails()) {
			return response()->json('', 409);
		}
		
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
				$comp->phone = $request->phone;
				$comp->services = json_encode($request->services);
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
			$comp->phone = $request->phone;
			$comp->services = json_encode($request->services);
			$comp->save();
			
			return response()->json('', 200);
		} catch(\Exception $e) {
			return response()->json($e->getMessage(), 500);
		}
	}
}
