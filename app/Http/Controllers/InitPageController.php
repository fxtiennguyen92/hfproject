<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Service;

class InitPageController extends Controller
{
	public function viewIndexPage() {
		$serviceModel = new Service();
		$services = $serviceModel->getAll();
		
		return view(Config::get('constants.INDEX_PAGE'), array(
			'services' => $services
		));
	}
	
	public function viewHomePage() {
		$serviceModel = new Service();
		$services = $serviceModel->getAll();
		
		return view(Config::get('constants.HOME_PAGE'), array(
			'services' => $services
		));
	}
	
	public function viewDashboardPage() {
		return view(Config::get('constants.DASHBOARD_PAGE'), array(
		));
	}
	
	public function test() {
		
	}
}
