<?php

namespace App\Http\Controllers\Mng;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use App\User;
use App\ProProfile;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\MailController;

class ProController extends Controller
{
	public function viewList() {
		$userModel = new User();
		$pros = $userModel->getAllPro();
		
		return view(Config::get('constants.PRO_MNG_PAGE'), array(
						'pros' => $pros,
		));
	}

	public function active($proId) {
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

	public function modify($id = null, Request $request) {
		
	}
}
