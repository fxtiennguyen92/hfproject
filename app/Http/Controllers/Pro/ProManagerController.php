<?php

namespace App\Http\Controllers\Pro;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\User;

class ProManagerController extends Controller
{

	public function viewProListPage() {
		$userModel = new User();
		$pros = $userModel->getProsByProManager(auth()->user()->id);
		
		return view(Config::get('constants.PRO_MNG_PAGE'), array(
						'pros' => $pros,
		));
	}

	public function deleteByProManager($proId) {
		$userModel = new User();
		$pro = $userModel->getProByProManager($proId, auth()->user()->id);
		if (!$pro) {
			response()->json('', 400);
		}
		
		try {
			$userModel->updateDeleteFlg($proId, Config::get('constants.FLG_ON'));
			
			response()->json('', 200);
		} catch (\Exception $e) {
			response()->json('', 400);
		}
	}
}
