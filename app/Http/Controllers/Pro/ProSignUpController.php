<?php

namespace App\Http\Controllers\Pro;

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
use App\Http\Controllers\CommonController;

class ProSignUpController extends Controller
{
	protected function validator(array $data) {
		return Validator::make($data, [
						'email' => 'string|email|max:255|unique:users',
						'phone' => 'numeric|unique:users',
		]);
	}

	public function view() {
		$commonModel = new Common();
		$serviceModel = new Service();
		
		$cities = $commonModel->getCityList();
		$districts = null;
		if ($cities) {
			$districts = $commonModel->getDistList($cities->first()->code);
		}
		$services = $serviceModel->getAll();
		
		// pro manager
		$company = null;
		if (auth()->check()) {
			if (auth()->user()->role == Config::get('constants.ROLE_PRO_MNG')) {
				$profileModel = new ProProfile();
				$manager = $profileModel->getById(auth()->user()->id);
				
				$companyModel = new Company();
				$company = $companyModel->get($manager->company_id);
			}
		}
		
		return view(Config::get('constants.PRO_SIGN_UP_PAGE'), array(
						'cities' => $cities,
						'districts' => $districts,
						'company' => $company,
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
			DB::beginTransaction();
			
			// company
			if ($request->operationMode == 1) {
				$comp = new Company();
				$comp->name = $request->nameComp;
				$comp->address = $request->addressComp;
				$comp->district = $request->distComp;
				$comp->city = $request->cityComp;
				$comp->services = json_encode($request->services);
				$comp->save();
			}
			
			// account
			$user = new User();
			$user->name = $request->name;
			$user->email = $request->email;
			$user->phone = $request->phone;
			
			$user->role = Config::get('constants.ROLE_PRO');
			if ($request->operationMode == 1) {
				$user->role = Config::get('constants.ROLE_PRO_MNG');
			}
			
			if (auth()->check()) {
				$user->created_by = auth()->user()->id;
			}
			$user->save();
			
			// profile
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
			$pro->services = json_encode($request->services);
			
			if (auth()->check()) {
				if (auth()->user()->role == Config::get('constants.ROLE_PRO_MNG')) {
					$profileModel = new ProProfile();
					$manager = $profileModel->getById(auth()->user()->id);
					
					$pro->company_id = $manager->company_id;
				} else {
					if ($request->operationMode == 1) {
						$pro->company_id = $comp->id;
					}
				}
				
				$pro->created_by = auth()->user()->id;
			} else {
				if ($request->operationMode == 1) {
					$pro->company_id = $comp->id;
				}
				$pro->created_by = $user->id;
			}
			
			$pro->save();
			DB::commit();
			return response()->json('', 200);
		} catch(\Exception $e) {
			DB::rollBack();
			return response()->json($e->getMessage(), 500);
		}
	}
}
