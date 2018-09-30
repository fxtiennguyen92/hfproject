<?php

namespace App\Http\Controllers\Mng;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Order;
use App\Http\Controllers\CommonController;

class OrderController extends Controller
{
	public function viewList(Request $request) {
		$fromDate = '';
		$endDate = new \DateTime();
		if ($request->fromDate) {
			$fromDate = CommonController::convertStringToDate($request->fromDate);
		}
		if ($request->endDate) {
			$endDate = CommonController::convertStringToDate($request->endDate);
		}
		
		$orderModel = new Order();
		$orders = $orderModel->getAll($fromDate, $endDate);
		
		// report
		$frm = '';
		$end = '';
		if ($fromDate) {
			$frm = date('Y-m-01 00:00:00', strtotime($fromDate->format('Y-m-d')));
		}
		if ($endDate) {
			$end = date('Y-m-t 23:59:59', strtotime($endDate->format('Y-m-d')));
		}
		$orderCountReport = $orderModel->reportOrderCountByMonth($frm, $end);
		$orderValueReport = $orderModel->reportOrderValueByMonth($frm, $end);
		
		return view(Config::get('constants.MNG_ORDER_LIST_PAGE'), array(
						'orders' => $orders,
						'orderCountReport' => $orderCountReport,
						'orderValueReport' => $orderValueReport,
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
			return redirect()->route('mng_order_list');
		} catch (\Exception $e) {
			DB::rollback();
			return Redirect::back()->withInput()->with('error', $e->getMessage());
		}
	}
}
