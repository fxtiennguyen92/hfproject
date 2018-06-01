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
use App\Blog;
use App\Doc;
use App\Wallet;

class InitPageController extends Controller
{
	public function __construct() {
		$this->getServiceHint();
	}
	
	public function viewHomePage() {
		if (auth()->check() && auth()->user()->role == Config::get('constants.ROLE_PRO')) {
			return $this->viewDashboardPage();
		}
		
		$serviceModel = new Service();
		$roots = $serviceModel->getAllServingRoots();
		$services = $serviceModel->getMostPopular();
		
		$commonModel = new Common();
		$parts = $commonModel->getByKey(Config::get('constants.HOME_PAGE'));
		
		$blogModel = new Blog();
		$blogs = $blogModel->getNewestBlogs();
		
		return view(Config::get('constants.HOME_PAGE'), array(
						'roots' => $roots,
						'services' => $services,
						'blogs' => $blogs,
						'parts' => $parts,
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
	
	public function viewBlogPage($urlName = null) {
		$blogModel = new Blog();
		
		if (!$urlName) {
			$genBlogs = $blogModel->getTopGeneralBlog();
			$proBlogs = $blogModel->getTopProBlog();
			
			return view(Config::get('constants.BLOG_PAGE'), array(
						'nav' => 'blog',
						'genBlogs' => $genBlogs,
						'proBlogs' => $proBlogs
			));
		}
		
		$blog = $blogModel->getByUrlName($urlName);
		if (!$blog) {
			throw new NotFoundHttpException();
		}
		
		$page = new \stdClass();
		$page->name = 'Blog';
		$page->back_route = 'blog_page';
		
		return view(Config::get('constants.BLOG_CONTENT_PAGE'), array(
						'nav' => 'blog',
						'page' => $page,
						'blog' => $blog,
		));
	}

	public function viewDocPage($urlName) {
		$docModel = new Doc();
		
		$doc = $docModel->getByUrlName($urlName);
		if (!$doc) {
			throw new NotFoundHttpException();
		}
		
		return view(Config::get('constants.DOC_PAGE'), array(
						'doc' => $doc,
		));
	}

	public function control() {
		if (!auth()->check()) {
			return redirect()->route('login_page');
		}
		
		if (auth()->user()->role == Config::get('constants.ROLE_ADM')) {
			return view(Config::get('constants.MNG_CONTROL_PAGE'), array(
			));
		}
		
		$userModel = new User();
		$walletModel = new Wallet();
		$commonModel = new Common();
// 		if (auth()->user()->role == Config::get('constants.ROLE_PRO')) {
			$user = $userModel->getPro(auth()->user()->id);
			$user->wallet = $walletModel->getById($user->id);
			$levels = $commonModel->getByKey(Config::get('constants.KEY_POINT_LEVEL'));
			
			return view(Config::get('constants.ACCOUNT_PAGE'), array(
				'levels' => $levels,
				'user' => $user,
			));
// 		}
	}
}
