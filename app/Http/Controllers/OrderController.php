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

class OrderController extends Controller
{

	public function __construct() {
//		$this->middleware('member');
	}

	public function viewList($style = null) {
		$orderModel = new Order();

		$processingOrders = $orderModel->getProcessingByMember(auth()->user()->id);
		$newOrders = $orderModel->getNewByMember(auth()->user()->id);
		
		return view(Config::get('constants.ORDER_LIST_PAGE'), array(
						'processingOrders' => $processingOrders,
						'newOrders' => $newOrders,
		));
	}

	public function view($orderId, Request $request) {
		$orderModel = new Order();
		$quotedPriceModel = new QuotedPrice();
		
		$order = $orderModel->getById($orderId);
		if (!$order) {
			throw new NotFoundHttpException();
		}
		// put orderId to session
		$request->session()->put('order', $orderId);
		
		// get qouted price
		$order->quoted_price = $quotedPriceModel->getByOrder($order->id);
		
		return view(Config::get('constants.ORDER_PAGE'), array(
						'order' => $order,
		));
	}

	public function accept($qpId, Request $request) {
		// get orderId from session
		if (!$request->session()->has('order')) {
			response()->json('', 400);
		}
		$orderId = $request->session()->get('order');
		
		// get and check order
		$orderModel = new Order();
		$order = $orderModel->getById($orderId);
		if (!$order) {
			response()->json('', 400);
		}
		
		// get and check quoted price
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
		$order = $orderModel->updateState($orderId, Config::get('constants.ORD_CANCEL'));
		
		response()->json('', 200);
	}
}
