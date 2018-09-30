<?php

namespace App\Http\Controllers;

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
use App\DiscountCode;

class OrderController extends Controller
{
	public function __construct() {
		$this->getServiceHint();
	}

	public function viewList($style = null, Request $request) {
		// redirect to login page if not member
		if (!auth()->check()) {
			return redirect()->route('login_page');
		}
		
		$orderModel = new Order();
		$currentOrders = $orderModel->getCurrentByMember(auth()->user()->id);
		
		$newOrders = $orderModel->getNewByMember(auth()->user()->id);
		
		$request->session()->forget('order'); // clear session
		
		return view(Config::get('constants.ORDER_LIST_PAGE'), array(
						'nav' => 'order',
						'currentOrders' => $currentOrders,
						'newOrders' => $newOrders,
		));
	}

	public function view($orderId, Request $request) {
		$orderModel = new Order();
		$order = $orderModel->getByIdAndUserId($orderId, auth()->user()->id);
		if (!$order) {
			throw new NotFoundHttpException();
		}
		
		// get qouted price
		$quotedPriceModel = new QuotedPrice();
		$order->quoted_price = $quotedPriceModel->getByOrder($order->id);
		
		// put orderId to session
		$request->session()->put('order', $orderId);
		
		$page = new \stdClass();
		$page->name = 'Đơn hàng';
		$page->back_route = 'order_list_page';
		
		return view(Config::get('constants.ORDER_PAGE'), array(
						'page' => $page,
						'order' => $order,
		));
	}

	public function accept($proId, Request $request) {
		// get orderId from session
		if (!$request->session()->has('order')) {
			return response()->json('', 400);
		}
		$orderId = $request->session()->get('order');
		
		// get and check order
		$orderModel = new Order();
		$order = $orderModel->getByIdAndUserId($orderId, auth()->user()->id);
		if (!$order) {
			return response()->json('', 400);
		}
		
		// get and check quoted price
		$qpId = $orderId.'-'.$proId;
		$quotedPriceModel = new QuotedPrice();
		$quotedPrice = $quotedPriceModel->getById($qpId);
		if (!$quotedPrice) {
			return response()->json('', 400);
		}
		
		if (!$order->est_excute_at) {
			$order->est_excute_at = date('Y-m-d H:i', strtotime('+'.env('ASAP_EXCUTE_DATE').'minutes'));
			$order->est_excute_at_string = CommonController::getStringAsapExcuteDateTime();
		}
		
		$order->id = $orderId;
		$order->total_price = $quotedPrice->price;
		$order->state = Config::get('constants.ORD_ACCEPTED');
		$order->pro_id = $quotedPrice->pro_id;
		
		try {
			DB::beginTransaction();
			$orderModel->acceptQuotedPrice($order);
			$quotedPriceModel->updateState($qpId, Config::get('constants.QPRICE_SUCCESS'));
		
			DB::commit();
			
			$this->sendOrderInfoMail(auth()->user()->mail, $order->id);
			
			return response()->json('', 200);
		} catch (\Exception $e) {
			DB::rollback();
			return response()->json('', 500);
		}
	}

	public function process(Request $request) {
		// get orderId from session
		if (!$request->session()->has('order')) {
			throw new NotFoundHttpException();
		}
		$orderId = $request->session()->get('order');
		
		// get and check order
		$orderModel = new Order();
// 		$order = $orderModel->getByIdAndUserId($orderId, auth()->user()->id);
// 		if (!$order) {
// 			return Redirect::back();
// 		}

		try {
			$orderModel->updateState($orderId, Config::get('constants.ORD_PROCESSING'));
			
			DB::commit();
		} catch (\Exception $e) {
			DB::rollback();
		}
		
		return Redirect::back();
	}

	public function complete(Request $request) {
		// get orderId from session
		if (!$request->session()->has('order')) {
			throw new NotFoundHttpException();
		}
		$orderId = $request->session()->get('order');
		$orderModel = new Order();
		$order = $orderModel->getById($orderId);
		if ($order->state === Config::get('constants.ORD_COMPLETE')) {
			if (auth()->user()->role == Config::get('constants.ROLE_USER')) {
				return Redirect::back()->with('review', true);
			}
			return Redirect::back();
		}
		
		try {
			DB::beginTransaction();
			$orderModel->updateState($orderId, Config::get('constants.ORD_COMPLETE'));

			$pro = User::find($order->pro_id);
			$pro->point = $pro->point + ($order->total_price / 1000);
			$pro->save();
			
			$proProfile = ProProfile::find($order->pro_id);
			$proProfile->total_orders = $proProfile->total_orders + 1;
			$proProfile->save();
			
			$user = User::find($order->user_id);
			$user->point = $user->point + ($order->total_price / 1000);
			$user->save();
			
			DB::commit();
			
			if (auth()->user()->role == Config::get('constants.ROLE_USER')) {
				return Redirect::back()->with('review', true);
			}
			return Redirect::back();
		} catch (\Exception $e) {
			DB::rollback();
			return Redirect::back()->with('error', $e->getMessage());
		}
	}

	public function cancel(Request $request) {
		// get orderId from session
		if (!$request->session()->has('order')) {
			throw new NotFoundHttpException();
		}
		$orderId = $request->session()->get('order');
		
		$orderModel = new Order();
		$orderModel->updateState($orderId, Config::get('constants.ORD_CANCEL'));
		
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

	public function review(Request $request) {
		// get orderId from session
		if (!$request->session()->has('order')) {
			return response()->json('', 400);
		}
		$orderId = $request->session()->get('order');
		
		$orderModel = new Order();
		$order = $orderModel->getById($orderId);
		
		$review = new Review();
		$review->id = $order->user_id.'#'.$order->no;
		$review->from_id = $order->user_id;
		$review->to_id = $order->pro_id;
		$review->order_id = $order->id;
		$review->rating = $request->rating;
		$review->content = $request->content;
		$review->save();
		
		$proProfile = ProProfile::find($order->pro_id);
		$proProfile->rating = (($proProfile->rating * $proProfile->total_review) + $request->rating) / ($proProfile->total_review + 1);
		$proProfile->total_review = $proProfile->total_review + 1;
		
		$levelArr = array();
		if (!$proProfile->lvl_total_review) {
			$levelArr = array(0,0,0,0,0);
		} else {
			$levelArr = json_decode($proProfile->lvl_total_review);
		}
		
		$levelArr[$request->rating - 1]++;
		$proProfile->lvl_total_review = json_encode($levelArr);
		$proProfile->save();
		
		return response()->json('', 200);
	}

	public function viewDiscountCodeList(Request $request) {
// 		if (!auth()->check()) {
// 			return response()->json('', 400);
// 		}
		
		$searchCode = $request->search;
		
		$disCodeModel = new DiscountCode();
		$codes = $disCodeModel->getUseableCodesByCode($searchCode ,0);
		
		return response()->json($codes);
	}

	private function sendOrderInfoMail($email, $orderId) {
		if (!$email) {
			return;
		}
		
		$orderModel = new Order();
		$order = $orderModel->getById($orderId);
		
		MailController::sendOrderInfoMail($email, $order);
	}
}
