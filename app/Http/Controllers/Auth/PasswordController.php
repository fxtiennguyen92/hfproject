<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Redirect;

class PasswordController extends Controller
{
	protected function validator(array $data) {
		return Validator::make($data, [
			'password' => 'required|confirmed|min:6|max:100|',
		]);
	}
	
	public function edit() {
		if (!auth()->check()) {
			return redirect()->route('home_page');
		}
		
		return view(Config::get('constants.PASSWORD_PAGE'));
	}
	
	public function update(Request $request) {
		if (!auth()->check()) {
			throw new NotFoundHttpException();
		}
		
		if (auth()->user()->password) {
			if (!(Hash::check($request->get('current_password'), auth()->user()->password))) {
				return Redirect::back()->withInput()->with('error', 'Mật khẩu hiện tại không chính xác');
			}
		}
		
		$validator = $this->validator($request->all());
		if ($validator->fails()) {
			$errors = $validator->errors()->getMessages();
			
			return Redirect::back()->withInput()->with('error', 'Mật khẩu không đúng định dạng');
		}
		
		$userModel = new User();
		$userModel->updatePassword(auth()->user()->id, $request->get('password'));
		
		return redirect()->route('control');
	}
	
	public function reset(Request $request) {
		if (!auth()->check()) {
			throw new NotFoundHttpException();
		}
		
		$userModel = new User();
		$userModel->updatePassword(auth()->user()->id);
		
		return redirect()->route('control');
	}
}
