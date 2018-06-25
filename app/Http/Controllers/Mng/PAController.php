<?php
namespace App\Http\Controllers\Mng;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use App\User;
use App\ProProfile;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\MailController;
use App\Common;
use App\Service;
use App\Http\Controllers\FileController;
use App\Company;
use Illuminate\Support\Facades\Validator;
use App\Event;
use App\EventUser;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\CommonController;

class PAController extends Controller
{
	protected function validator(array $data) {
		return Validator::make($data, [
						'name' => 'string|max:225',
						'email' => 'nullable|string|max:100|email',
						'phone' => 'string|max:25',
		]);
	}

	public function viewList() {
		$userModel = new User();
		$pas = $userModel->getAllPAForMng();
		
		return view(Config::get('constants.MNG_PA_LIST_PAGE'), array(
						'pas' => $pas,
		));
	}

	public function edit($id) {
		$commonModel = new Common();
		$serviceModel = new Service();
		$eventModel = new Event();
		$eventUserModel = new EventUser();
		$companyModel = new Company();
		$userModel = new User();
		
		$pro = $userModel->getProOrProManager($id);
		if (!$pro) {
			throw new NotFoundHttpException();
		}
		
		$cities = $commonModel->getCityList();
		
		$districts = $commonModel->getDistList($pro->city);
		$services = $serviceModel->getAll();
		$events = $eventModel->getAll();
		$companies = $companyModel->getAll();
		
		$joinedEvents = $eventUserModel->getByUserId($id);
		if (sizeof($joinedEvents) > 0) {
			$pro->event = $joinedEvents->first()->id;
		}
		
		return view(Config::get('constants.MNG_PRO_PAGE'), array(
						'pro' => $pro,
						'cities' => $cities,
						'districts' => $districts,
						'services' => $services,
						'events' => $events,
						'companies' => $companies
		));
	}

	public function update($id, Request $request, $returnFlg = true) {
		$validator = $this->validator($request->all());
		if ($validator->fails()) {
			return Redirect::back()->withInput()->with('error', 400);
		}
		
		// save image
		if ($request->avatar) {
			$image = $request->avatar;
			$baseToPhp = explode(',', $image); // remove the "data:image/png;base64,"
			if (sizeof($baseToPhp) == 2) {
				$data = base64_decode($baseToPhp[1]);
				FileController::saveAvatar($data, $id);
			}
		}
		if ($request->govEvidence) {
			$image = $request->govEvidence;
			$baseToPhp = explode(',', $image); // remove the "data:image/png;base64,"
			if (sizeof($baseToPhp) == 2) {
				$data = base64_decode($baseToPhp[1]);
				FileController::saveGovEnvidence($data, $id);
			}
		}
		
		try {
			DB::beginTransaction();
			
			$user = User::find($id);
			$pro = ProProfile::find($id);
			
			// account
			$user->name = $request->name;
			$user->email = $request->email;
			$user->phone = $request->phone;
			
			$user->save();
			
			// event
			if ($request->event != $pro->training) {
				if (!$pro->training) {
					$this->createEventUser($id, $request->event);
				} elseif (!$request->event) {
					$eventUserModel = new EventUser();
					$joinedEvent = $eventUserModel->getByEventIdAndUserId($pro->training, $id);
					$joinedEvent->delete();
				} else {
					$eventUserModel = new EventUser();
					$joinedEvent = $eventUserModel->getByEventIdAndUserId($pro->training, $id);
					$joinedEvent->id = $request->event;
					$joinedEvent->save();
				}
			}
			
			// profile
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
			$pro->company_id = $request->company;
			$pro->services = json_encode($request->services);
			$pro->training = $request->event;
			
			$pro->save();
			
			DB::commit();
			
			if ($returnFlg) {
				return redirect()->route('mng_pro_list');
			}
		} catch(\Exception $e) {
			DB::rollBack();
			return Redirect::back()->withInput()->with('error', $e->getMessage());
		}
	}

	public function active($id, Request $request) {
		$this->update($id, $request, false);
		
		$userModel = new User();
		$profileModel = new ProProfile();
		
		try {
			DB::beginTransaction();
			
			$userModel->activeProAccount($id);
			$profileModel->updateState($id, Config::get('constants.STS_READY'));
			
			DB::commit();
			
			// send message and email
			$this->sendMessageAndEmail($id);
			
			return redirect()->route('mng_pro_list');
		} catch (\Exception $e) {
			DB::rollback();
			return Redirect::back()->withInput()->with('error', $e->getMessage());
		}
	}

	public function delete($id) {
		try {
			DB::beginTransaction();
			
			$user = User::find($id);
			$user->delete();
			
			$pro = ProProfile::find($id);
			$pro->delete();
			
			DB::commit();
		} catch (\Exception $e) {
			DB::rollback();
		}
		
		return redirect()->route('mng_pro_list');
	}

	/** Partner Acquisition **/
	public function viewListForPA() {
		$userModel = new User();
		$compModel = new Company();
		$eventModel = new Event();
		
		$pros = $userModel->getAllProForPA();
		$companies = $compModel->getAll();
		$events = $eventModel->getAll();
		
		return view(Config::get('constants.PA_PRO_LIST_PAGE'), array(
						'pros' => $pros,
						'companies' => $companies,
						'events' => $events
		));
	}
	
	public function createForPA(Request $request) {
		$validator = $this->validator($request->all());
		if ($validator->fails()) {
			return response()->json($validator->errors()->first(), 409);
		}
		
		$userModel = new User();
		if ($userModel->existPhone($request->phone)) {
			return response()->json('Phone is registered', 409);
		}
		
		try {
			// create user
			$userId = $this->createUser($request);
			// create pro profile
			$this->createProProfile($userId, $request);
			
			if ($request->event !== '') {
				$this->createEventUser($userId, $request->event);
			}
			
			return response()->json('', 200);
		} catch (\Exception $e) {
			return response()->json($e->getMessage(), 400);
		}
	}
	
	public function deleteForPA($id) {
		$userModel = new User();
		$userModel->updateDeleteFlg($id, Config::get('constants.FLG_ON'));
		
		return redirect()->route('pa_pro_list');
	}
	
	private function createUser($request) {
		$user = new User();
		$user->name = $request->name;
		$user->phone = $request->phone;
		$user->password_temp = str_random(12);
		$user->password = bcrypt($user->password_temp);
		$user->confirm_flg = Config::get('constants.FLG_ON');
		$user->role = ($request->style == 2) ? Config::get('constants.ROLE_PRO_MNG') : Config::get('constants.ROLE_PRO');
		$user->created_by = (auth()->check()) ? auth()->user()->id : null;
		
		$user->save();
		return $user->id;
	}
	
	private function createProProfile($userId, $request) {
		$profile = new ProProfile();
		$profile->id = $userId;
		$profile->company_id = ($request->style != 0) ? $request->company : null;
		$profile->training = $request->event;
		$profile->created_by = (auth()->check()) ? auth()->user()->id : null;
		
		$profile->save();
	}
	
	private function createEventUser($userId, $eventId) {
		$eventUser = new EventUser();
		$eventUser->id = $eventId;
		$eventUser->user_id = $userId;
		$eventUser->created_by = $userId;
		$eventUser->created_by = (auth()->check()) ? auth()->user()->id : null;
		
		$eventUser->save();
	}
	
	private function sendMessageAndEmail($id) {
		$userModel = new User();
		$pro = $userModel->getProOrProManager($id);
		if ($pro->email) {
			$mail = new MailController();
			$mail->sendActiveProAccountMail($pro->name, $pro->email, $pro->password_temp);
		}
	}
}
