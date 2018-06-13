<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use App\User;
use Illuminate\Support\Facades\Redirect;
use App\Wallet;

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

	public function __construct() {
		$this->middleware('guest')->except('logout');
	}

	public function username() {
		return 'phone';
	}

	public function view() {
		if (Auth::check()) {
			return redirect()->back();
		}
		
		return view(Config::get('constants.LOGIN_PAGE'));
	}

	public function authenticate(Request $request) {
		$user = User::checkLoginAccount($request);
		if ($user) {
			if ($user->delete_flg == Config::get('constants.FLG_ON')) { // User is deleted
				return Redirect::back()->withInput()->with('error', 400);
			}
			
			if ($user->confirm_flg == Config::get('constants.FLG_OFF')) { // Email is not confirmed
				return Redirect::back()->withInput()->with('error', 406);
			}
			
			Auth::login($user);
			$this->createWalletForOldAcc($user->id);
			
			return $this->redirectPath($request);
		} else {
			return Redirect::back()->withInput()->with('error', 401);
		}
	}

	public static function redirectPath(Request $request = null) {
		if (!Auth::check()) {
			return redirect()->route('home_page');
		}
		
		if (Auth::user()->role === Config::get('constants.ROLE_PRO')) {
			return redirect()->route('dashboard_page');
		}
		
		if ($request && $request->session()->has('back_service')) {
			$service = $request->session()->get('back_service');
			$request->session()->forget('back_service');
			
			return redirect()->route('service_view', ['url_name' => $service]);
		}
		return redirect()->route('home_page');
	}

	public function logout(Request $request) {
		Auth::logout();
		$request->session()->flush();
		return redirect()->route('home_page');
	}

	public static function relogin() {
		Auth::logout();
		return redirect()->route('login_page');
	}

	public static function createWalletForOldAcc($id) {
		$walletModel = new Wallet();
		$wallet = $walletModel->getById($id);
		if ($wallet) {
			return true;
		}
		
		$wallet = new Wallet();
		$wallet->id = $id;
		$wallet->save();
		return true;
	}
}
