<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Order;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Request;
use App\QuotedPrice;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Review;
use Illuminate\Support\Facades\Redirect;
use App\ProProfile;

class OrderController extends Controller
{
	public function __construct() {
	}

	public function viewList($style = null) {
		// redirect to login page if not member
		if (!auth()->check()) {
			return redirect()->route('login_page');
		}
		
		$orderModel = new Order();
		$currentOrders = $orderModel->getCurrentByMember(auth()->user()->id);
		
		//$newOrders = $orderModel->getNewByMember(auth()->user()->id);
		
		return view(Config::get('constants.ORDER_LIST_PAGE'), array(
						'nav' => 'order',
						'currentOrders' => $currentOrders,
						//'newOrders' => $newOrders,
		));
	}

	public function view($orderId, Request $request) {
		$orderModel = new Order();
		$quotedPriceModel = new QuotedPrice();
		
		$order = $orderModel->getByIdAndUserId($orderId, auth()->user()->id);
		if (!$order) {
			throw new NotFoundHttpException();
		}
		// put orderId to session
		$request->session()->put('order', $orderId);
		
		// get qouted price
		$order->quoted_price = $quotedPriceModel->getByOrder($order->id);
		
// 		return view(Config::get('constants.ORDER_PAGE'), array(
// 						'order' => $order,
// 		));
		
		$page = new \stdClass();
		$page->name = 'Đơn hàng';
		$page->back_route = 'order_list_page';
		if (auth()->user()->role == 1) {
			$page->back_route = 'pro_order_list_page';
		}
		
		return view('order_detail', array(
						'page' => $page,
						'order' => $order,
		));
	}

	public function accept($proId, Request $request) {
		// get orderId from session
		if (!$request->session()->has('order')) {
			response()->json('', 400);
		}
		$orderId = $request->session()->get('order');
		
		// get and check order
		$orderModel = new Order();
		$order = $orderModel->getByIdAndUserId($orderId, auth()->user()->id);
		if (!$order) {
			response()->json('', 400);
		}
		
		// get and check quoted price
		$qpId = $orderId.'-'.$proId;
		$quotedPriceModel = new QuotedPrice();
		$quotedPrice = $quotedPriceModel->getById($qpId);
		if (!$quotedPrice) {
			response()->json('', 400);
		}
		
		if (!$order->est_excute_at) {
			$order->est_excute_at = $quotedPrice->est_excute_at;
			$order->est_excute_at_string = $quotedPrice->est_excute_at_string;
		}
		
		$order->id = $orderId;
		$order->total_price = $quotedPrice->price;
		$order->state = Config::get('constants.ORD_PROCESSING');
		$order->pro_id = $quotedPrice->pro_id;
		
		
		try {
			DB::beginTransaction();
			$orderModel->acceptQuotedPrice($order);
			$quotedPriceModel->updateState($qpId, Config::get('constants.QPRICE_SUCCESS'));
		
			DB::commit();
			response()->json('', 200);
		} catch (\Exception $e) {
			DB::rollback();
			response()->json('', 400);
		}
	}

	public function cancel($orderId, Request $request) {
		$orderModel = new Order();
		$isUpdated = $orderModel->updateState($orderId, Config::get('constants.ORD_CANCEL'));
		
		if ($isUpdated) {
			response()->json('', 200);
		} else {
			response()->json('', 400);
		}
	}
	
	public function finish(Request $request) {
		// get orderId from session
		if (!$request->session()->has('order')) {
			throw new NotFoundHttpException();
		}
		$orderId = $request->session()->get('order');
		
		try {
			DB::beginTransaction();
			$orderModel = new Order();
			$orderModel->updateState($orderId, '1');
			$order = $orderModel->updateState($orderId, Config::get('constants.ORD_COMPLETE'));
			
			// set income for pro
			$order = $orderModel->getById($orderId);
			$profile = ProProfile::where('id', $order->pro_id)->first();
			$profile->total_orders = $profile->total_orders + 1;
			$profile->total_order_price = $profile->total_order_price + $order->total_price;
			$profile->point = $profile->point + ($order->total_price / 1000);
			$profile->save();

			DB::commit();
		} catch (\Exception $e) {
			DB::rollback();
		}
		
		return Redirect::back();
	}
	
	public function viewProPage($proId, Request $request) {
		// get orderId from session
		if (!$request->session()->has('order')) {
			throw new NotFoundHttpException();
		}
		$orderId = $request->session()->get('order');
		
		// get and check order
		$orderModel = new Order();
		$order = $orderModel->getByIdAndUserId($orderId, auth()->user()->id);
		if (!$order) {
			throw new NotFoundHttpException();
		}
		
		// get quoted price from proId
		$quotedPriceModel = new QuotedPrice();
		$quotedPrice = $quotedPriceModel->getById($orderId.'-'.$proId);
		if (!$quotedPrice) {
			throw new NotFoundHttpException();
		}
		
		// get pro info
		$userModel = new User();
		$pro = $userModel->getPro($proId);
		if (!$pro) {
			throw new NotFoundHttpException();
		}
		
		$reviewModel = new Review();
		$pro->reviews = $reviewModel->getByPro($proId);
		
		$page = new \stdClass();
		$page->name = 'Đối tác';
		
		return view(Config::get('constants.PRO_PAGE'), array(
						'action' => 'order',
						'page' => $page,
						'pro' => $pro,
						'orderId' => $orderId,
		));
	}
}
