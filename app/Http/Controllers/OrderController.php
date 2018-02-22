<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Order;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Request;
use App\QuotedPrice;
use App\User;

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
		
		$order->quoted_price = $quotedPriceModel->getByOrder($order->id);
		
		return view(Config::get('constants.ORDER_PAGE'), array(
						'order' => $order,
		));
	}

	public function accept($orderId, $qpId, Request $request) {
		// session
// 		if (!$request->session()->has('quoted_order')) {
// 			response()->json('', 400);
// 		}
		
		$orderModel = new Order();
		$quotedPriceModel = new QuotedPrice();
		
		$quotedPrice = $quotedPriceModel->getById($qpId);
		
		$order = $orderModel->getById($orderId);
		if (!$order->est_excute_at) {
			$order->est_excute_at = $quotedPrice->est_excute_at;
		}
		$order->id = $quotedPrice->pro_id;
		$order->total_price = $quotedPrice->price;
		$order->state = Config::get('constants.ORD_PROCESSING');
		
		$orderModel->acceptQuotedPrice($order);
		$quotedPriceModel->updateState($qpId, Config::get('constants.QPRICE_SUCCESS'));
		
		response()->json('', 200);
	}
}
