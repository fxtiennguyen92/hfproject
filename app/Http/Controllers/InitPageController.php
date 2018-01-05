<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class InitPageController extends Controller
{
	public function viewIndexPage() {
		//$groups = ServiceGroup::all();
		return view(Config::get('constants.INDEX_PAGE'), array(
			//'groups' => $groups
		));
	}
	
	public function viewHomePage() {
		return view(Config::get('constants.HOME_PAGE'), array(
		));
	}
	
	public function viewDashboardPage() {
		return view(Config::get('constants.DASHBOARD_PAGE'), array(
		));
	}
	
	public function test() {
		
	}
}
