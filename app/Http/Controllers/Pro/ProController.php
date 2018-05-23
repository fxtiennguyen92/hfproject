<?php

namespace App\Http\Controllers\Pro;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Common;
use App\Service;
use Illuminate\Http\Request;
use App\ProProfile;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\CommonController;
use App\Event;
use App\EventUser;

class ProController extends Controller
{
	protected function validator(array $data) {
		return Validator::make($data, [
						'name' => 'string|max:225',
						'email' => 'nullable|string|max:100|email|unique:users',
						'phone' => 'string|max:25|unique:users',
		]);
	}

	public function newPro() {
		$commonModel = new Common();
		$serviceModel = new Service();
		$eventModel = new Event();
		
		$services = $serviceModel->getAllServingChildren();
		$events = $eventModel->getAll();
		
		$cities = $commonModel->getCityList();
		$districts = $commonModel->getDistList();
		
		return view(Config::get('constants.PRO_SIGNUP_PAGE'), array(
						'cities' => $cities,
						'districts' => $districts,
						'services' => $services,
						'events' => $events
		));
	}

	public function create(Request $request) {
		$validator = $this->validator($request->all());
		if ($validator->fails()) {
			return response()->json($validator->errors()->first(), 409);
		}
		
		// register
		try {
			DB::beginTransaction();

			// account
			$user = new User();
			$user->name = $request->name;
			$user->email = $request->email;
			$user->phone = $request->phone;
			
			$user->role = Config::get('constants.ROLE_PRO');
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
			$pro->address_1 = $request->address_1;
			$pro->address_2 = $request->address_2;
			$pro->district = $request->dist;
			$pro->city = $request->city;
			$pro->services = json_encode($request->services);
			$pro->training = $request->event;
			$pro->created_by = $user->id;
			if (auth()->check()) {
				$pro->created_by = auth()->user()->id;
			}
			
			$pro->save();
			
			// event
			if ($request->event) {
				$eventUser = new EventUser();
				$eventUser->id = $request->event;
				$eventUser->user_id = $user->id;
				$eventUser->created_by = $user->id;
				if (auth()->check()) {
					$eventUser->created_by = auth()->user()->id;
				}
				
				$eventUser->save();
			}
			
			DB::commit();
			return response()->json('', 200);
		} catch(\Exception $e) {
			DB::rollBack();
			return response()->json($e->getMessage(), 500);
		}
	}
}
