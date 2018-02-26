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

	public function viewList($style = null) {
		$orderModel = new Order();
		$quotedPriceModel = new QuotedPrice();
		$newOrders = $orderModel->getNewByPro(auth()->user()->id);
		$quotedOrders = $quotedPriceModel->getNewByPro(auth()->user()->id);
		
		return view(Config::get('constants.PRO_ORDER_LIST_PAGE'), array(
						'newOrders' => $newOrders,
						'quotedOrders' => $quotedOrders,
		));
	}

	public function view($orderId, Request $request) {
		$order = new Order();
		$order = $order->getById($orderId);
		if (!$order) {
			throw new NotFoundHttpException();
		}
		
		// put orderId to session
		$request->session()->put('order', $orderId);
		
		// get qouted price
		$quotedPrice = new QuotedPrice();
		$quotedPrice = $quotedPrice->getById($orderId.'-'.auth()->user()->id);
		
		return view(Config::get('constants.PRO_ORDER_PAGE'), array(
						'order' => $order,
						'quotedPrice' => $quotedPrice
		));
	}

	public function quotePrice(Request $request) {
		// get orderId from session
		if (!$request->session()->has('order')) {
			response()->json('', 400);
		}
		$orderId = $request->session()->get('order');
		
		$orderModel = new Order();
		$order = $orderModel->getById($orderId);
		if (!$order) {
			response()->json('', 400);
		}

		$estDate = null;
		$estDateStr = null;
		if (!$order->est_excute_at_string) {
			$date = CommonController::convertStringToDateTime(substr($request->estTime, -16));
			if ($date) {
				$estDate = $date;
				$estDateStr = $request->estTime;
			}
		}
		
		QuotedPrice::updateOrCreate([
						'qp_id' => $orderId.'-'.auth()->user()->id
		],[
						'order_id' => $orderId,
						'pro_id' => auth()->user()->id,
						'price' => $request->price,
						'est_excute_at' => $estDate,
						'est_excute_at_string' => $estDateStr,
		]);
		
		response()->json('', 200);
	}
	
}
