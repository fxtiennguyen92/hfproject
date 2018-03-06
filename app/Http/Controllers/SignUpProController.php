<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Common;
use App\Company;
use App\Service;
use Illuminate\Http\Request;
use App\ProProfile;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SignUpProController extends Controller
{
	protected function validator(array $data) {
		return Validator::make($data, [
						'email' => 'string|email|max:255|unique:users',
						'phone' => 'numeric|unique:users',
		]);
	}

	public function view() {
		$commonModel = new Common();
		$companyModel = new Company();
		$serviceModel = new Service();
		
		$cities = $commonModel->getCityList();
		$districts = null;
		if ($cities) {
			$districts = $commonModel->getDistList($cities->first()->code);
		}
		$companies = $companyModel->getAll();
		$services = $serviceModel->getAll();
		
		return view(Config::get('constants.SIGN_UP_PRO_PAGE'), array(
						'cities' => $cities,
						'districts' => $districts,
						'companies' => $companies,
						'services' => $services
		));
	}

	public function signup(Request $request) {
		$validator = $this->validator($request->all());
		if ($validator->fails()) {
			return response()->json('', 409);
		}
		
		// register
		try {
			$excuter = '';
			if (auth()->check()) {
				$excuter = auth()->user()->id;
			}
			
			DB::beginTransaction();
			$user = new User();
			$user->name = $request->name;
			$user->email = $request->email;
			$user->phone = $request->phone;
			
			$user->role = Config::get('constants.ROLE_PRO');
			if ($request->operationMode == 1) {
				$user->role = Config::get('constants.ROLE_PRO_MNG');
			}
			
			$user->created_by = $excuter;
			$user->save();
			
			$pro = new ProProfile();
			$pro->id = $user->id;
			$pro->date_of_birth = CommonController::convertStringToDate($request->dateOfBirth);
			$pro->gender = $request->gender;
			$govId = array(
				'id' => $request->govId,
				'date' => $request->govDate,
				'place' => $request->govPlace
			);
			$pro->gov_id = json_encode($govId);
			$pro->fg_address = $request->familyRegAddress;
			$pro->fg_district = $request->familyRegDist;
			$pro->fg_city = $request->familyRegCity;
			$pro->address = $request->address;
			$pro->district = $request->dist;
			$pro->city = $request->city;
			$pro->company_id = $request->company;
			$pro->services = json_encode($request->services);
			$pro->created_by = $excuter;
			$pro->save();
			
			if ($request->operationMode == 1) {
				$comp = new Company();
				$comp->name = $request->nameComp;
				$comp->address = $request->addressComp;
				$comp->district = $request->distComp;
				$comp->city = $request->cityComp;
				$comp->services = json_encode($request->services);
				$comp->save();
			}
			
			DB::commit();
			return response()->json('', 200);
		} catch(\Exception $e) {
			DB::rollBack();
			return response()->json($e->getMessage(), 500);
		}
	}
}
