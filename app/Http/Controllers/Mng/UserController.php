<?php
namespace App\Http\Controllers\Mng;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\User;

class UserController extends Controller
{
	public function viewList() {
		$userModel = new User();
		$users = $userModel->getAllUserForMng();
		
		return view(Config::get('constants.MNG_USER_LIST_PAGE'), array(
						'users' => $users,
		));
	}
}
