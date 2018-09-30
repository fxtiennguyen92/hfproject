<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;
use App\SAC;
use App\Http\Controllers\FileController;

class UserController extends Controller
{
	protected function validator(array $data) {
		return Validator::make($data, [
						'name' => 'required|string|max:100',
						'email' => 'required|string|email|max:100|unique:users',
						'phone' => 'required|string|unique:users',
						'password' => 'required|string|min:6|max:100',
		]);
	}
	
	public function userRegister(Request $request) {
		try {
			$validator = $this->validator($request->all());
			if ($validator->fails()) {
				return response()->json($validator->errors()->getMessages(), 422);
			}
			
			SAC::destroy($request->phone);
			
			$user = new User();
			$user->name = $request->name;
			$user->email = $request->email;
			$user->phone = $request->phone;
			$user->password = bcrypt($request->password);
			$user->facebook_id = ($request->facebook_id) ? $request->facebook_id : null;
			$user->google_id = ($request->google_id) ? $request->google_id : null;
			
			$user->device_token = $request->deviceToken;
			$user->confirm_flg = 1;
			$user->save();
			
			if ($request->facebook_id) {
				$fbAvatarUrl = 'https://graph.facebook.com/'.$request->facebook_id.'/picture?type=large';
				$data = file_get_contents($fbAvatarUrl);
				FileController::saveAvatar($data, $user->id);
			}
			if ($request->google_id) {
				$ggAvatarUrl = $request->picture;
				$data = file_get_contents($ggAvatarUrl);
				FileController::saveAvatar($data, $user->id);
			}
			
			$token = JWTAuth::fromUser($user);
			return response()->json(compact('token'), 200);
		} catch (\Exception $e) {
			return response()->json($e->getMessage(), 500);
		}
	}
	
	public function userCheckRegisterInfo(Request $request) {
		try {
			$validator = $this->validator($request->all());
			if ($validator->fails()) {
				return response()->json($validator->errors()->getMessages(), 422);
			}
			
			return response()->json('', 200);
		} catch (\Exception $e) {
			return response()->json($e->getMessage(), 500);
		}
	}
	
	public function userLogin(Request $request) { 
		$account = $request->only('phone', 'password');
		try {
			if (!$token = JWTAuth::attempt($account)) {
				return response()->json('', 401);
			}
			
			$user = User::api_getUserByPhone($request->phone);
			$user->device_token = $request->deviceToken;
			$user->save();
		} catch (JWTException $e) {
			return response()->json($e->getMessage(), 500);
		}
		
		return response()->json(compact('token'), 200);
	}
	
	public function userLoginByFacebook(Request $request) {
		try {
			$user = User::api_getUserByFacebookAccount($request->email, $request->id);
			if ($user) {
				$user->email = $request->email;
				$user->facebook_id = $request->id;
				$user->device_token = $request->deviceToken;
				$user->save();
				
				try {
					$token = JWTAuth::fromUser($user);
					return response()->json(compact('token'), 200);
				} catch (JWTException $e) {
					return response()->json($e->getMessage(), 500);
				}
			}
			
			return response()->json('', 204);
		} catch (\Exception $e) {
			return response()->json($e->getMessage(), 500);
		}
	}
	
	public function userLoginByGoogle(Request $request) {
		try {
			$user = User::api_getUserByGoogleAccount($request->email, $request->id);
			if ($user) {
				$user->email = $request->email;
				$user->google_id = $request->id;
				$user->device_token = $request->deviceToken;
				$user->save();
				
				try {
					$token = JWTAuth::fromUser($user);
					return response()->json(compact('token'), 200);
				} catch (JWTException $e) {
					return response()->json($e->getMessage(), 500);
				}
			}
			
			return response()->json('', 204);
		} catch (\Exception $e) {
			return response()->json($e->getMessage(), 500);
		}
	}
}
