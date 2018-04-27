<?php

namespace App\Http\Controllers\Mng;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Order;

class OrderController extends Controller
{
	public function viewList() {
		$orderModel = new Order();
		$orders = $orderModel->getAll();
		
		return view(Config::get('constants.MNG_ORDER_LIST_PAGE'), array(
						'orders' => $orders,
		));
	}

	public function cancel($orderNo, Request $request) {
		$orderModel = new Order();
		$order = $orderModel->getByNo($orderNo);
		if (!$order) {
			return Redirect::back()->withInput()->with('error', 400);
		}

		try {
			DB::beginTransaction();
			Order::updateState($order->id, Config::get('constants.ORD_CANCEL'));
			
			DB::commit();
			return redirect()->route('mng_order_list_page');
		} catch (\Exception $e) {
			DB::rollback();
			return Redirect::back()->withInput()->with('error', $e->getMessage());
		}
	}
}
