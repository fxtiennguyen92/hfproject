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

class ProController extends Controller
{

	protected function validator(array $data) {
		return Validator::make($data, [
						'name' => 'required|string|max:150',
						'phone' => 'required|string|max:25',
		]);
	}

	public function viewList() {
		$userModel = new User();
		$pros = $userModel->getAllPro();
		
		return view(Config::get('constants.MNG_PRO_LIST_PAGE'), array(
						'pros' => $pros,
		));
	}

	public function viewProfile($proId, Request $request) {
		$commonModel = new Common();
		$serviceModel = new Service();
		$userModel = new User();
		
		$pro = $userModel->getProOrProManager($proId);
		
		$cities = $commonModel->getCityList();
		$districts = null;
		if ($cities) {
			$districts = $commonModel->getDistList($cities->first()->code);
		}
		$services = $serviceModel->getAllServing();

		// put proId to session
		$request->session()->put('proId', $proId);

		return view(Config::get('constants.MNG_PRO_PROFILE_PAGE'), array(
						'pro' => $pro,
						'cities' => $cities,
						'districts' => $districts,
						'services' => $services
		));
	}

	public function approveAvatar(Request $request) {
		if (!$request->session()->has('proId')) {
			response()->json('', 400);
		}
		$proId = $request->session()->get('proId');
		
		$image = $request->only('image');
		$baseToPhp = explode(',', $image['image']); // remove the "data:image/png;base64,"
		
		try {
			$data = base64_decode($baseToPhp[1]);
			FileController::saveAvatar($data, $proId);
			
			return redirect()->back();
		} catch (\Exception $e) {
			return response()->json('', 400);
		}
	}

	public function active(Request $request) {
		if (!$request->session()->has('proId')) {
			response()->json('', 400);
		}
		$proId = $request->session()->get('proId');
		
		$userModel = new User();
		$profileModel = new ProProfile();
		
		$pro = $userModel->getProOrProManager($proId);
		if (!$pro) {
			return response()->json('', 400);
		}
		
		try {
			DB::beginTransaction();
			
			$userModel->activeProAccount($proId);
			$profileModel->updateState($proId, Config::get('constants.STS_READY'));
			
			DB::commit();
			
			// send mail
			$pro = $userModel->getProOrProManager($proId);
			$mail = new MailController();
			$mail->sendActiveProAccountMail($pro->name, $pro->email, $pro->password_temp);
			
			return response()->json('', 200);
		} catch (\Exception $e) {
			DB::rollback();
			return response()->json('', 400);
		}
	}

	public function updateCV(Request $request) {
		if (!$request->session()->has('proId')) {
			response()->json('', 400);
		}
		$proId = $request->session()->get('proId');
		
		$profileModel = new ProProfile();
		$profileModel->updateInspection($proId, json_encode($request->inspection));
		
		return response()->json('', 200);
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
		$profile->created_by = (auth()->check()) ? auth()->user()->id : null;
		
		$profile->save();
	}
	
	private function createEventUser($userId, $eventId) {
		$eventUser = new EventUser();
		$eventUser->event_id = $eventId;
		$eventUser->user_id = $userId;
		$eventUser->created_by = $userId;
		if (auth()->check()) {
			$eventUser->created_by = auth()->user()->id;
		}
		
		$eventUser->save();
	}
}
