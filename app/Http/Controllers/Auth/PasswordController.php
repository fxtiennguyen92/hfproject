<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Support\Facades\Validator;

class PasswordController extends Controller
{
	protected function validator(array $data) {
		return Validator::make($data, [
			'password' => 'required|confirmed|min:6|max:100|',
		]);
	}
	
	public function view() {
// 		if (!auth()->check()) {
// 			return redirect()->route('home_page');
// 		}
		
		return view(Config::get('constants.PASSWORD_PAGE'), array(
			
		));
	}
	
	public function change(Request $request) {
		if (!auth()->check()) {
			throw new NotFoundHttpException();
		}
		
		if (auth()->user()->password) {
			if (!(Hash::check($request->get('current_password'), auth()->user()->password))) {
				return response()->json('', 401);
			}
		}
		
		$validator = $this->validator($request->all());
		if ($validator->fails()) {
			$errors = $validator->errors()->getMessages();
			
			return response()->json('', 409);
		}
		
		$userModel = new User();
		$userModel->updatePassword(auth()->user()->id, $request->get('password'));
		
		return response()->json('', 200);
	}
}
