<?php

namespace App\Http\Controllers\Pro;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Order;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Request;
use App\QuotedPrice;

class ProOrderController extends Controller
{

	public function __construct() {
//		$this->middleware('pro');
	}

	public function viewOrder($orderId, Request $request) {
		$order = new Order();
		$order = $order->getById($orderId);
		if (!$order) {
			throw new NotFoundHttpException();
		}
		
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
		//dd($request->all());
		
		// session
		if (!$request->session()->has('quoted_order')) {
			response()->json('', 400);
		}
		$orderId = $request->session()->get('quoted_order');
		
		QuotedPrice::updateOrCreate([
						'id' => $orderId.'#'.auth()->user()->id
		],[
						'order_id' => $orderId,
						'pro_id' => auth()->user()->id,
						'price' => $request->price
		]);
		
		return '';
	}
}
