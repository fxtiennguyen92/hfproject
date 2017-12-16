<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\MailController;

class RegisterController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Register Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users as well as their
	| validation and creation. By default this controller uses a trait to
	| provide this functionality without requiring any additional code.
	|
	*/

	use RegistersUsers;

	/**
	 * Where to redirect users after registration.
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
		$this->middleware('guest');
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data) {
		return Validator::make($data, [
			'name' => 'required|string|max:255',
			'email' => 'required|string|email|max:255|unique:users',
			'phone' => 'required|numeric|unique:users',
			'password' => 'required|string|min:10',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return \App\User
	 */
	protected function create(array $data) {
		return User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'phone' => $data['phone'],
			'password' => bcrypt($data['password']),
			'confirm_code' => str_random(45),
		]);
	}

	/**
	 * View partner sign up page
	 *
	 * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
	 */
	public function view() {
		return view(Config::get('constants.SIGNUP_PAGE'), array(
		));
	}

	/**
	 * Handle a registration request for the application.
	 * 
	 * @param Request $request
	 * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
	 */
	public function authenticate(Request $request) {
		$req = $request->all();
		
		$validator = $this->validator($req);
		if ($validator->fails()) {
			$errors = $validator->errors()->getMessages();
			
			return response()->json($errors, 409);
		}
		
		// registration
		$user = $this->create($request->all());
		
		$mail = new MailController();
		$mail->sendVerifyMail($user->name, $user->email, $user->confirm_code);
		
		// go to confirm email page
		dd('Confirm email to active'); die;
	}

	public function verify($confirmCode) {
		$user = User::where('confirm_code', $confirmCode)->first();
		
		if (!$user) {
			dd('verify_error');die;
		}
		
		$user->confirm_flg = 1;
		$user->confirm_code = null;
		$user->save();
		
		Auth::login($user);
		return redirect($this->redirectPath());
	}
}
