<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Service;
use App\Common;
use App\User;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Review;
use App\Order;

class InitPageController extends Controller
{
	public function viewHomePage() {
		if (auth()->check() && auth()->user()->role == Config::get('constants.ROLE_PRO')) {
			return $this->viewDashboardPage();
		}
		
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
		$orderModel = new Order();
		$orders = $orderModel->getNewByPro(auth()->user()->id);
		
		return view(Config::get('constants.DASHBOARD_PAGE'), array(
						'orders' => $orders
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
		if (!auth()->check()) {
			return redirect()->route('login_page');
		}
		
		return view(Config::get('constants.CONTROL_PAGE'), array(
			'nav' => 'control',
		));
	}
}
