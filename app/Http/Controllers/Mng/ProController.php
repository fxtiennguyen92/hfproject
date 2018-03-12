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

class ProController extends Controller
{
	public function viewList() {
		$userModel = new User();
		$pros = $userModel->getAllPro();
		
		return view(Config::get('constants.PRO_MNG_PAGE'), array(
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
		$services = $serviceModel->getAll();

		// put proId to session
		$request->session()->put('proId', $proId);

		return view(Config::get('constants.PRO_PROFILE_MNG_PAGE'), array(
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
			response()->json('', 400);
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
			
			response()->json('', 200);
		} catch (\Exception $e) {
			DB::rollback();
			response()->json('', 400);
		}
	}

	public function updateCV(Request $request) {
		if (!$request->session()->has('proId')) {
			response()->json('', 400);
		}
		$proId = $request->session()->get('proId');
		
		$profileModel = new ProProfile();
		$profileModel->updateInspection($proId, json_encode($request->inspection));
		
		response()->json('', 200);
	}
}
