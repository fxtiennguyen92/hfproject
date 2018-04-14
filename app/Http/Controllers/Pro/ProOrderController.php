<?php

namespace App\Http\Controllers\Pro;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Order;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Request;
use App\QuotedPrice;
use App\User;
use App\Http\Controllers\CommonController;

class ProOrderController extends Controller
{

	public function __construct() {
//		$this->middleware('pro');
	}

	public function viewList() {
		$quotedPriceModel = new QuotedPrice();
		$quotedOrders = $quotedPriceModel->getByPro(auth()->user()->id);
		
		return view(Config::get('constants.PRO_ORDER_LIST_PAGE'), array(
						'nav' => 'order',
						'quotedOrders' => $quotedOrders,
		));
	}

	public function view($orderId, Request $request) {
		$order = new Order();
		$order = $order->getById($orderId);
		if (!$order) {
			throw new NotFoundHttpException();
		}
		
		// get qouted price
		$quotedPrice = new QuotedPrice();
		$quotedPrice = $quotedPrice->getById($orderId.'-'.auth()->user()->id);
		
		// put orderId to session
		$request->session()->put('order', $orderId);
		
		$page = new \stdClass();
		$page->name = 'Đơn hàng';
		$page->back_route = 'pro_order_list_page';
		
		$dates = CommonController::getNext2Days();
		$times = CommonController::getAllTimes();
		
		return view(Config::get('constants.ORDER_PAGE'), array(
						'page' => $page,
						'order' => $order,
						'quotedPrice' => $quotedPrice,
						'dates' => $dates,
						'times' => $times,
		));
	}

	public function quotePrice(Request $request) {
		// get orderId from session
		if (!$request->session()->has('order')) {
			response()->json('', 400);
		}
		$orderId = $request->session()->get('order');
		
		$orderModel = new Order();
		$order = $orderModel->getNewById($orderId);
		if (!$order) {
			response()->json('', 400);
		}

		// check excute date
		$estExcuteDate = null;
		$estExcuteDateString = null;
		if (!$order->est_excute_at_string) {
			$estExcuteDateString = $request->estDate.' '.$request->estTime;
			if (strlen($estExcuteDateString) < 16) {
				return response()->json('', 403);
			}
			
			$currDate = new \DateTime('now');
			$estExcuteDate = CommonController::convertStringToDateTime(substr($estExcuteDateString, -16));
			if ($estExcuteDate === null || $estExcuteDate <= $currDate) {
				return response()->json('', 403);
			}
		}
		
		QuotedPrice::updateOrCreate([
						'qp_id' => $orderId.'-'.auth()->user()->id
		],[
						'order_id' => $orderId,
						'pro_id' => auth()->user()->id,
						'price' => $request->price,
						'introduction' => $request->introduction,
						'est_excute_at' => $estExcuteDate,
						'est_excute_at_string' => $estExcuteDateString,
		]);
		
		response()->json('', 200);
	}
	
}
