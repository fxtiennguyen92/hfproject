<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
	public function login(Request $request){ 
		if(Auth::attempt(['phone' => request('phone'), 'password' => request('password')])) {
			$user = Auth::user();
			$success['token'] =  $user->createToken('HandFree')-> accessToken; 
			
			return response()->json('test', 200);
		} else {
			return response()->json(['error'=>'Unauthorised'], 401);
		}
	}
	
	public function generateAPI() {
// 		$users = User::all();
// 		foreach ($users as $user) {
// 			$user->api_token = str_random(60);
// 			$user->save();
// 		}
	}
}
