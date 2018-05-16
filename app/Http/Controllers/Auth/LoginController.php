<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Session\Session;
use App\User;

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
		return 'phone';
	}

	/**
	 * View log in page.
	 * 
	 * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
	 */
	public function view() {
		if (Auth::check()) {
			return redirect()->back();
		}
		
		return view(Config::get('constants.LOGIN_PAGE'));
	}

	/**
	 * Handle an authentication attempt.
	 *
	 * @return Response
	 */
	public function authenticate(Request $request) {
		$user = User::checkLoginAccount($request);
		if ($user) {
			Auth::login($user);
			return $this->redirectPath();
		} else {
			return response()->json('', 401);
		}
	}

	/**
	 * Redirect after login.
	 * 
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public static function redirectPath() {
		if (!Auth::check()) {
			return redirect()->route('home_page');
		}
		
		if (Auth::user()->role === Config::get('constants.ROLE_PRO')) {
			return redirect()->route('dashboard_page');
		}
		
		return redirect()->route('home_page');
	}

	/**
	 * Log out.
	 * 
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function logout(Request $request) {
		Auth::logout();
		$request->session()->flush();
		return redirect()->route('home_page');
	}
}
