<?php
namespace App\Http\Controllers\Mng;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\User;

class AccountController extends Controller
{
	public function viewList() {
		$userModel = new User();
		$accounts = $userModel->getAllAcc();
		
		return view(Config::get('constants.MNG_ACC_LIST_PAGE'), array(
						'accounts' => $accounts,
		));
	}
}
