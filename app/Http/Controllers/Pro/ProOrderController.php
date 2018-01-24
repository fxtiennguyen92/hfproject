<?php

namespace App\Http\Controllers\Pro;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Order;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Request;
use App\QuotedPrice;
use App\User;

class ProOrderController extends Controller
{

	public function __construct() {
//		$this->middleware('pro');
	}

	public function viewOrders($style = null) {
		$order = new Order();
		//$orders = $order->getByPro(auth()->user()->id);
		$newOrders = $order->getNewByPro(auth()->user()->id);
		$quotedOrders = $order->getQuotedByPro(auth()->user()->id);
		//$completeOrders = $order->getCompleteByPro(auth()->user()->id);
		
// 		dd($quotedOrders);
		
		return view(Config::get('constants.PRO_ORDER_LIST_PAGE'), array(
						'newOrders' => $newOrders,
						'quotedOrders' => $quotedOrders,
		));
	}

	public function viewOrder($orderId, Request $request) {
		$order = new Order();
		$order = $order->getById($orderId);
		if (!$order) {
			throw new NotFoundHttpException();
		}
		// avatar of customer
		$order['user_avatar'] = User::getAvatar($order->user_id);
		
		// put orderId to session
		$request->session()->put('quoted_order', $orderId);
		
		// get qouted price
		$quotedPrice = new QuotedPrice();
		$quotedPrice = $quotedPrice->getById($orderId.'#'.auth()->user()->id);
		
		return view(Config::get('constants.PRO_ORDER_PAGE'), array(
						'order' => $order,
						'quotedPrice' => $quotedPrice
		));
	}

	public function quotePrice(Request $request) {
		// session
		if (!$request->session()->has('quoted_order')) {
			response()->json('', 400);
		}
		
		// TODO check state of order - ERROR 417
		
		$orderId = $request->session()->get('quoted_order');
		
		QuotedPrice::updateOrCreate([
						'id' => $orderId.'#'.auth()->user()->id
		],[
						'order_id' => $orderId,
						'pro_id' => auth()->user()->id,
						'price' => $request->price
		]);
		
		response()->json('', 200);
	}
}
