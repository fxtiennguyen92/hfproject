<?php

namespace App\Http\Controllers;

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
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InitPageController extends Controller
{
	public function __construct() {
		$this->getServiceHint();
	}
	
	public function viewHomePage() {
		if (auth()->check() && !auth()->user()->phone) {
			return redirect()->route('login_page')->with('error', 428);
		}
		
		if (auth()->check() && auth()->user()->role == Config::get('constants.ROLE_PRO')) {
			return $this->viewDashboardPage();
		}
		
		if (auth()->check() && auth()->user()->role > 80) {
			return $this->control();
		}
		
		$serviceModel = new Service();
		$roots = $serviceModel->getAllServingRoots();
		$services = $serviceModel->getMostPopular();
		
		$commonModel = new Common();
		$banners = $commonModel->getByKey(Config::get('constants.BANNER'));
		$mbBanners = $commonModel->getByKey(Config::get('constants.BANNER_MB'));
		$parts = $commonModel->getByKey(Config::get('constants.HOME_PAGE'));
		
		
		$blogModel = new Blog();
		$blogs = $blogModel->getNewestBlogs();
		
		return view(Config::get('constants.HOME_PAGE'), array(
						'roots' => $roots,
						'services' => $services,
						'blogs' => $blogs,
						'parts' => $parts,
						'banners' => $banners,
						'mbbanners' => $mbBanners,
		));
	}
	
	public function viewDashboardPage() {
		$orderModel = new Order();
		$orders = $orderModel->getNewByPro(auth()->user()->id, auth()->user()->profile->services);
		
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
			$blogs = $blogModel->getNewestBlogs();
			$highlights = $blogModel->getHighlightBlogs();
			$categories = $blogModel->getCategories();
			
			return view(Config::get('constants.BLOG_PAGE'), array(
						'blogs' => $blogs,
						'highlights' => $highlights,
						'categories' => $categories
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

	public function viewSearchPage(Request $request) {
		$commonModel = new Common();
		$serviceModel = new Service();
		
		$cities = $commonModel->getCityList();
		$districts = $commonModel->getDistList($request->city);
		$services = $serviceModel->getAllServingRoots();
		
		$result = array();
		if ($request->city) {
			$result = $this->searchProAndComp($request);
		}
		
		return view(Config::get('constants.SEARCH_PAGE'), array(
						'cities' => $cities,
						'districts' => $districts,
						'services' => $services,
						'result' => $result,
		));
	}

	public function control() {
		if (!auth()->check()) {
			return redirect()->route('login_page');
		}
		
		if (auth()->user()->role == Config::get('constants.ROLE_CSO')) {
			return redirect()->route('mng_user_list');
		}
		
		if (auth()->user()->role == Config::get('constants.ROLE_PA')) {
			return redirect()->route('pa_pro_list');
		}
		
		if (auth()->user()->role == Config::get('constants.ROLE_ADM')) {
			return redirect()->route('mng_pa_list');
		}
		
		$userModel = new User();
		$walletModel = new Wallet();
		$commonModel = new Common();
// 		if (auth()->user()->role == Config::get('constants.ROLE_PRO')) {
			$user = $userModel->getAvailableAcc(auth()->user()->id);
			
			if (!$user) {
				LoginController::relogin();
			}
			
			$levels = $commonModel->getByKey(Config::get('constants.KEY_POINT_LEVEL'));
			
			return view(Config::get('constants.ACCOUNT_PAGE'), array(
				'levels' => $levels,
				'user' => $user,
			));
// 		}
	}
	
	private function searchProAndComp($request) {
		$pdo = DB::connection('mysql')->getPdo();
		
		$query = "
			SELECT * FROM (
				SELECT id, companies.name as name, address_1, address_2
					, companies.district, companies.city
					, dist.name as district_name, city.name as city_name
					, location, image
					, style as services
					, 'comp' as type FROM companies
					LEFT JOIN commons as dist
						ON dist.code = companies.district
					LEFT JOIN commons as city
						ON city.code = companies.city
				UNION ALL
				SELECT pro_profiles.id as id, users.name as name, address_1, address_2
					, pro_profiles.district, pro_profiles.city
					, dist.name as district_name, city.name as city_name
					, location, users.avatar as image
					, service_str as services
					, 'pro' as type FROM pro_profiles
					LEFT JOIN users
						ON users.id = pro_profiles.id
					LEFT JOIN commons as dist
						ON dist.code = pro_profiles.district
					LEFT JOIN commons as city
						ON city.code = pro_profiles.city
			) as items
			WHERE 1=1 AND items.location IS NOT NULL
		";
		if ($request->name) {
			$query .= " AND items.name LIKE '%".$request->name."%'";
		}
		if ($request->city) {
			$query .= " AND items.city = '".$request->city."'";
		}
		if ($request->dist) {
			$in = "('" . implode("','", $request->dist) ."')";
			$query .= " AND items.district IN ".$in;
		}
		if ($request->service) {
			$arr = "('" . implode("','", $request->service) ."')";
			foreach ($request->service as $str) {
				$query .= " AND items.services LIKE '%".$str."%'";
			}
		}
		$query .= " ORDER BY items.name LIMIT 20";
		
		$stmt = $pdo->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll((\PDO::FETCH_ASSOC));
	}
}
