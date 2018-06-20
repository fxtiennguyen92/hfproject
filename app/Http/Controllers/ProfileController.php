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
}
