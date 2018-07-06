<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\SMSController;
use App\Http\Controllers\SACController;

class PasswordController extends Controller
{
	protected function validator(array $data) {
		return Validator::make($data, [
			'password' => 'required|confirmed|min:6|max:100|',
		]);
	}
	
	protected function phone_validator(array $data) {
		return Validator::make($data, [
						'phone' => 'required|string',
		]);
	}
	
	public function edit() {
		return view(Config::get('constants.PASSWORD_PAGE'));
	}
	
	public function update(Request $request) {
		if (!auth()->check()) {
			return response()->json('', 400);
		}
		
		if (auth()->user()->password) {
			if (!(Hash::check($request->get('current_password'), auth()->user()->password))) {
				return response()->json('', 401);
			}
		}
		
		$validator = $this->validator($request->all());
		if ($validator->fails()) {
			$errors = $validator->errors()->getMessages();
			return response()->json($errors, 409);
		}
		
		try {
			$userModel = new User();
			$userModel->updatePassword(auth()->user()->id, $request->get('password'));
		
			return response()->json('', 200);
		} catch (\Exception $e) {
			return response()->json($e->getMessage(), 500);
		}
	}
	
	public function getSAC(Request $request) {
		if (!$request->phone) {
			return response()->json('', 400);
		}
		$validator = $this->phone_validator($request->all());
		if ($validator->fails()) {
			$errors = $validator->errors()->getMessages();
			return response()->json($errors, 409);
		}
		
		$userModel = new User();
		$user = $userModel->getAccByPhone($request->phone);
		if (!$user) {
			return response()->json('', 406);
		}
		
		try {
			$sac = SACController::getSAC($request->phone);
			$result = SMSController::sendPINCodeSMS($request->phone, $sac->sac);
			
			if ($result) {
				return response()->json('', 200);
			} else {
				SACController::deleteSAC($request->phone);
				return response()->json('', 503);
			}
		} catch (\Exception $e) {
			return response()->json($e->getMessage(), 500);
		}
	}
	
	public function reset(Request $request) {
		if (SACController::checkSAC($request->phone, $request->sac) == false) {
			return response()->json('', 401);
		}
		
		try {
			$userModel = new User();
			$user = $userModel->getAccByPhone($request->phone);
			$userModel->updatePassword($user->id);
			SACController::deleteSAC($request->phone);
			
			$user = User::find($user->id);
			if (!SMSController::sendNewPasswordSMS($user->phone, $user->password_temp)) {
				return response()->json('', 503);
			}
			
			return response()->json('', 200);
		} catch (\Exception $e) {
			return response()->json($e->getMessage(), 500);
		}
	}
}
