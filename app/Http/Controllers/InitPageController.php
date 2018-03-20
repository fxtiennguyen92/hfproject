<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Service;
use App\Common;
use App\User;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Review;

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
	
	public function viewProPage($proId) {
		$userModel = new User();
		$pro = $userModel->getPro($proId);
		if (!$pro) {
			throw new NotFoundHttpException();
		}
		
		$reviewModel = new Review();
		$pro->reviews = $reviewModel->getByPro($proId);
		
		$page = new \stdClass();
		$page->name = 'Đối tác';
		$page->back_route = 'home_page';
		
		return view(Config::get('constants.PRO_PAGE'), array(
			'page' => $page,
			'pro' => $pro
		));
	}
	
	public function control() {
		return view(Config::get('constants.CONTROL_PAGE'), array(
			'nav' => 'control',
		));
	}
}
