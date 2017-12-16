<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class LoginController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles authenticating users for the application and
	| redirecting them to your home screen. The controller uses a trait
	| to conveniently provide its functionality to your applications.
	|
	*/

	use AuthenticatesUsers;

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo = '/test';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('guest')->except('logout');
	}

	/**
	 * Define username
	 * 
	 * @return string
	 */
	public function username() {
		return 'email';
	}

	/**
	 * View log in page.
	 * 
	 * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
	 */
	public function view() {
		return view(Config::get('constants.LOGIN_PAGE'));
	}

	/**
	 * Handle an authentication attempt.
	 *
	 * @return Response
	 */
	public function authenticate(Request $request) {
		$data = [
			'email' => $request->email,
			'password' => $request->password,
			'delete_flg' => 0,
			'confirm_flg' => 1
		];
		
		if (Auth::attempt($data)) {
			return $this->redirectPath();
		} else {
			return response()->json('', 401);
		}
	}

	/**
	 * Redirect after login
	 * 
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function redirectPath() {
		if (!Auth::check()) {
			return redirect()->route('index_page');
		}
		if (Auth::user()->role == 0) {
			return redirect()->route('home_page');
		} else if (Auth::user()->role == 1) {
			return redirect()->route('dashboard_page');
		}
	}

	/**
	 * Log out.
	 * 
	 */
	public function logout() {
		Auth::logout();
		return redirect()->route('index_page');
	}
}
