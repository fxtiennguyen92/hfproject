<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Common;

class SignUpProController extends Controller
{
	public function view() {
		$commonModel = new Common();
		
		$cities = $commonModel->getCityList();
		return view(Config::get('constants.SIGN_UP_PRO_PAGE'), array(
						'cities' => $cities,
		));
	}
}
