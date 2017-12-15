<?php

namespace App\Http\Controllers\Auth;

use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;

class SocialAuthController extends Controller
{
	public function redirectFB() {
		return Socialite::driver('facebook')->redirect();
	}

	public function callbackFB() {
		// when facebook call us a with token
		$user = Socialite::driver('facebook')->user();
		return $this->authenticate($user);
	}

	public function redirectGG() {
		return Socialite::driver('google')->redirect();
	}

	public function callbackGG() {
		$user = Socialite::driver('google')->user();
		return $this->authenticate($user, 1);
	}

	private function authenticate($user, $socialNetwork = 0) {
		// Check existed user
		$registedUser = User::where(function ($query) use ($user) {
				$query->where('email', '=', $user->email)
				->orWhere('facebook_id', '=', $user->id)
				->orWhere('google_id', '=', $user->id);
		})->first();
		
		if ($registedUser) {
			if ($registedUser->delele_flg != 0) { // User is deleted
				// TODO: Error Page User Can not Use
			}
			
			if ($registedUser->confirm_flg != 1) { // Email is not confirmed
				// TODO: Redirect Confirm Email Page
			}
		} else {
			// Create new user
			$registedUser = $this->create($user, $socialNetwork);
		}

		// Login
		Auth::login($registedUser);
		$loginController = new LoginController();
		return $loginController->redirectPath();
	}

	private function create($user, $socialNetwork = 0) {
		if ($socialNetwork == 0) { // Facebook
			return User::create([
				'name' => $user->name,
				'email' => $user->email,
				'facebook_id' => $user->id,
				'avatar' => str_random(10),
				'confirm_flg' => 1,
			]);
		} else { // Google
			return User::create([
				'name' => $user->name,
				'email' => $user->email,
				'google_id' => $user->id,
				'avatar' => str_random(10),
				'confirm_flg' => 1,
			]);
		}
	}
}
