<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Service;
use App\Common;

class InitPageController extends Controller
{
	public function viewHomePage() {
		$serviceModel = new Service();
		$services = $serviceModel->getAll();
		
		$commonModel = new Common();
		$parts = $commonModel->getByKey(Config::get('constants.HOME_PAGE'));
		
		return view(Config::get('constants.HOME_PAGE'), array(
			'services' => $services,
			'parts' => $parts
		));
	}
	
	public function viewDashboardPage() {
		return view(Config::get('constants.DASHBOARD_PAGE'), array(
		));
	}
	
	public function control() {
		return view(Config::get('constants.CONTROL_PAGE'), array(
			'nav' => 'control',
		));
	}
}
