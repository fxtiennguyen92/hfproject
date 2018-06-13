<?php

namespace App\Http\Controllers\Pro;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\ProProfile;
use App\Http\Controllers\CommonController;

class ProProfileController extends Controller
{

	public function __construct() {
		$this->middleware('pro');
	}

	public function view() {
		$proProfile = new ProProfile();
		$profile = $proProfile->getById(auth()->user()->id);
		
		return view(Config::get('constants.PRO_PROFILE_PAGE'), array(
						'profile' => $profile
		));
	}

	public function changeAvatar(Request $request) {
		$image = $request->only('image');
		$baseToPhp = explode(',', $image['image']); // remove the "data:image/png;base64,"
		
		$data = base64_decode($baseToPhp[1]);
		FileController::saveAvatar($data);
		
		return redirect()->back();
	}

	/**
	 * Change password.
	 * 
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function changePassword(Request $request) {
		// Check current password
		if ($request->has('currPassword')) {
			if (!(Hash::check($request->get('currPassword'), auth()->user()->password))) {
				return response()->json('', 401);
			}
		}
		
		// Check new password and current password
		if(strcmp($request->get('currPassword'), $request->get('newPassword')) == 0){
			return response()->json('', 400);
		}
		
		// Check new password and confirm new password
		$validator = $this->validator($request->all());
		if ($validator->fails()) {
			return response()->json($errors, 409);
		}
		
		// Change password
		$user = Auth::user();
		$user->password = bcrypt($request->get('newPassword'));
		$user->save();
		
		return redirect()->back();
	}

	public function changeProfile(Request $request) {
		$newProfile = $request->all();
		$newProfile['id'] = auth()->user()->id;
		
		$user = Auth::user();
		$user->name = $newProfile['name'];
		$user->phone = $newProfile['phone'];
		$user->save();
		
		$profile = ProProfile::updateOrCreate([
			'id' => auth()->user()->id
		],[
			'date_of_birth' => CommonController::convertStringToDate($newProfile['dateOfBirth']),
			'gender' => $newProfile['gender'],
		]);
		
		return response()->json('', 200);
	}

	/**
	 * Get a validator.
	 * 
	 * @param array $data
	 * @return validator
	 */
	protected function validator(array $data) {
		return Validator::make($data, [
			'newPassword' => 'required|string|min:10',
			'rePassword' => 'required|string|same:newPassword',
		]);
	}
}
