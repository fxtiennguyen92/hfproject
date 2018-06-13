<?php

namespace App\Http\Controllers\Auth;

use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\FileController;
use Illuminate\Http\Request;

class SocialAuthController extends Controller
{
	public function redirectFB() {
		return Socialite::driver('facebook')->redirect();
	}

	public function callbackFB(Request $request) {
		// when facebook call us a with token
		$user = Socialite::driver('facebook')->user();
		return $this->authenticate($user, 0, $request);
	}

	public function redirectGG() {
		return Socialite::driver('google')->redirect();
	}

	public function callbackGG(Request $request) {
		$user = Socialite::driver('google')->user();
		return $this->authenticate($user, 1, $request);
	}

	private function authenticate($user, $socialNetwork = 0, $request) {
		// Check existed user
		$registedUser = User::where(function ($query) use ($user) {
				$query
					->where('email', '=', $user->email)
					->orWhere('facebook_id', '=', $user->id)
					->orWhere('google_id', '=', $user->id);
				})->first();
		
		if ($registedUser) {
			if ($registedUser->delete_flg == Config::get('constants.FLG_ON')) { // User is deleted
				return redirect()->route('login_page')->with('error', 400);
			}
			
			if ($registedUser->confirm_flg == Config::get('constants.FLG_OFF')) { // Email is not confirmed
				return redirect()->route('login_page')->with('error', 406);
			}
		} else {
			// Create new user
			$registedUser = $this->create($user, $socialNetwork);
		}
		
		// Login
		Auth::login($registedUser);
		LoginController::createWalletForOldAcc($registedUser->id);
		
		// Get image from Socialite
		$data = file_get_contents($user->getAvatar());
		FileController::saveAvatar($data);
		
		return LoginController::redirectPath($request);
	}

	private function create($user, $socialNetwork = 0) {
		if ($socialNetwork == 0) { // Facebook
			return User::create([
				'name' => $user->name,
				'email' => $user->email,
				'facebook_id' => $user->id,
				'confirm_flg' => Config::get('constants.FLG_ON'),
			]);
		} else { // Google
			return User::create([
				'name' => $user->name,
				'email' => $user->email,
				'google_id' => $user->id,
				'confirm_flg' => Config::get('constants.FLG_ON'),
			]);
		}
	}
}
