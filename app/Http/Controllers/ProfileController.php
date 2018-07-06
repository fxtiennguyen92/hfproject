<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use App\Survey;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{

	protected function account_validator(array $data) {
		return Validator::make($data, [
						'name' => 'required|string|max:255',
						'email' => 'required|string|email|max:100',
						'phone' => 'required|string',
						'sac' => 'required|string|min:4|max:4',
		]);
	}

	protected function phone_validator(array $data) {
		return Validator::make($data, [
						'phone' => 'required|string|unique:users',
		]);
	}

	public function __construct() {
	}

	public function updatePhone(Request $request) {
		if (!auth()->check()) {
			return response()->json('', 400);
		}
		
		$validator = $this->phone_validator($request->all());
		if ($validator->fails()) {
			$errors = $validator->errors()->getMessages();
			return response()->json($errors, 409);
		}
		
		if (SACController::checkSAC($request->phone, $request->sac) == false) {
			return response()->json('', 401);
		}
		
		try {
			DB::beginTransaction();
			
			$userModel = new User();
			$userModel->updatePhone(auth()->user()->id, $request->phone);
			SACController::deleteSAC($request->phone);
			
			DB::commit();
			return response()->json('', 200);
		} catch (\Exception $e) {
			DB::rollback();
			return response()->json($e->getMessage(), 500);
		}
	}

	public function updateAccount(Request $request) {
		if (!auth()->check()) {
			return response()->json('', 400);
		}
		
		$validator = $this->phone_validator($request->all());
		if ($validator->fails()) {
			$errors = $validator->errors()->getMessages();
			return response()->json($errors, 412);
		}
		
		$userModel = new User();
		$currUser = $userModel->getAvailableAcc(auth()->user()->id);
		if (!$currUser) {
			return response()->json('', 400);
		}
		
		
		DB::beginTransaction();
		try {
			if ($currUser->name !== $request->name) {
				$userModel->updateName(auth()->user()->id, $request->name);
			}
			
			if ($currUser->phone !== $request->phone) {
				if ($userModel->existPhone($request->phone, auth()->user()->id)) {
					DB::rollback();
					return response()->json('', 409);
				}
				
				if (SACController::checkSAC($request->phone, $request->sac) == false) {
					DB::rollback();
					return response()->json('', 401);
				}
				
				$userModel->updatePhone(auth()->user()->id, $request->phone);
				SACController::deleteSAC($request->phone);
			}
			
			if ($currUser->email !== $request->email) {
				if ($userModel->existEmail($request->email, auth()->user()->id)) {
					DB::rollback();
					return response()->json('', 409);
				}
				
				$confirmCode = str_random(45);
				$userModel->updateEmail(auth()->user()->id, $request->email, $confirmCode);
				MailController::sendVerifyMail($request->name, $request->email, $confirmCode);
			}
			
			DB::commit();
			return response()->json('', 200);
		} catch (\Exception $e) {
			DB::rollback();
			return response()->json($errors, 500);
		}
	}
}
