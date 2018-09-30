<?php
namespace App\Http\Controllers\Mng;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Validator;

class PAController extends Controller
{
	protected function validator(array $data) {
		return Validator::make($data, [
						'name' => 'required|string|max:225',
						'email' => 'required|string|email|max:100|unique:users',
						'phone' => 'required|string|max:25|unique:users',
		]);
	}

	public function viewList() {
		$userModel = new User();
		$pas = $userModel->getAllPAForMng();
		
		return view(Config::get('constants.MNG_PA_LIST_PAGE'), array(
						'pas' => $pas,
		));
	}

	public function create(Request $request) {
		$validator = $this->validator($request->all());
		if ($validator->fails()) {
			return response()->json($validator->errors()->first(), 409);
		}
		
		try {
			$password = str_random(6);
			$account = User::create([
							'name' => $request->name,
							'email' => $request->email,
							'phone' => $request->phone,
							'password' => bcrypt($password),
							'password_temp' => $password,
							'confirm_flg' => Config::get('constants.FLG_ON'),
							'role' => Config::get('constants.ROLE_PA')
			]);
			
			MailController::sendAccountInfoMail($account->name, $account->phone, $account->email, $account->password_temp);
			
			return response()->json('', 200);
		} catch (\Exception $e) {
			return response()->json($e->getMessage(), 500);
		}
	}

	public function delete($id) {
		try {
			User::destroy($id);
			
		} catch (\Exception $e) {
			
		}
		
		return redirect()->route('mng_pa_list');
	}
}
