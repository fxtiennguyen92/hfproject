<?php

namespace App\Http\Controllers\Mng;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Common;
use App\Company;
use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;

class ProController extends Controller
{
	public function viewList() {
		$userModel = new User();
		$pros = $userModel->getAllPro()->toArray();
		
		return view(Config::get('constants.PRO_LIST_PAGE'), array(
						'pros' => $pros,
		));
	}

	public function view($id = null) {
		
	}

	public function modify($id = null, Request $request) {
		
	}
}
