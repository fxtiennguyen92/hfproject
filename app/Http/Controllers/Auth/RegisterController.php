<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\MailController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Http\Controllers\SMSController;
use App\Http\Controllers\SACController;

class RegisterController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Register Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users as well as their
	| validation and creation. By default this controller uses a trait to
	| provide this functionality without requiring any additional code.
	|
	*/

	use RegistersUsers;

	public function __construct() {
	}

	protected function validator(array $data) {
		return Validator::make($data, [
			'name' => 'required|string|max:255',
			'email' => 'required|string|email|max:255|unique:users',
			'phone' => 'required|string|unique:users',
			'password' => 'required|string|min:6|max:100',
		]);
	}

	protected function phone_validator(array $data) {
		return Validator::make($data, [
			'phone' => 'required|string|unique:users',
		]);
	}

	protected function create(array $data) {
		return User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'phone' => $data['phone'],
			'password' => bcrypt($data['password']),
			'confirm_code' => str_random(45),
		]);
	}

	public function view() {
		return view(Config::get('constants.SIGNUP_PAGE'));
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
		
		try {
			$sac = SACController::getSAC($request->phone);
			$result = SMSController::sendSMSActivateCode($request->phone, $sac->sac);
			
			if ($result) {
				return response()->json('', 200);
			} else {
				return response()->json('', 503);
			}
		} catch (\Exception $e) {
			return response()->json($e->getMessage(), 500);
		}
	}

	public function authenticate(Request $request) {
		// check reCaptcha
		$reCaptcha = new ReCaptcha();
		$chkCaptcha = $reCaptcha->verifyResponse(
			$_SERVER['REMOTE_ADDR'],
			$_POST['g-recaptcha-response']
		);
		if ($chkCaptcha == null || !$chkCaptcha->success) {
			return response()->json('CAPTCHA error', 429);
		}
		
		// validate
		$validator = $this->validator($request->all());
		if ($validator->fails()) {
			$errors = $validator->errors()->getMessages();
			return response()->json($errors, 409);
		}
		
		if (SACController::checkSAC($request->phone, $request->sac) == false) {
			return response()->json('', 401);
		}
		
		try {
			DB::beginTransaction();
			
			$user = $this->create($request->all());
			SACController::deleteSAC($user->phone);
			if ($user->email) {
				$mail = new MailController();
				$mail->sendVerifyMail($user->name, $user->email, $user->confirm_code);
			}
		
			DB::commit();
			return response()->json('', 200);
		} catch (\Exception $e) {
			DB::rollback();
			return response()->json($e->getMessage(), 500);
		}
	}

	public function verify($confirmCode) {
		$user = User::where('confirm_code', $confirmCode)->first();
		if (!$user) {
			throw new NotFoundHttpException();
		}
		
		$user->confirm_flg = Config::get('constants.FLG_ON');
		$user->confirm_code = null;
		$user->save();
		
		Auth::login($user);
		return LoginController::redirectPath();
	}
}
