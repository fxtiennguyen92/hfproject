<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PasswordController extends Controller
{
	protected function validator(array $data) {
		return Validator::make($data, [
			'password' => 'required|string|min:6|max:100',
		]);
	}
	
	public function view() {
// 		if (!auth()->check()) {
// 			return redirect()->route('home_page');
// 		}
		
		return view(Config::get('constants.PASSWORD_PAGE'), array(
			
		));
	}
	
	public function change($request) {
		// 		if (!auth()->check()) {
		// 			throw new NotFoundHttpException();
		// 		}
		
		return view(Config::get('constants.PASSWORD_PAGE'), array(
						
		));
	}
}
