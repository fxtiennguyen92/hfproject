<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use App\Http\Controllers\CommonController;
use App\QuotedPrice;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\User;

class OrderController extends Controller
{
	
	public function userGetAll() {
		try {
			//$user = auth()->user();
			$user = new \stdClass();
			$user->id = 194;
			
			$active = Order::api_getActive($user->id);
			$nonActive = Order::api_getNonActive($user->id);
			$history = Order::api_getHistory($user->id);
			
			$orders = array(
				'active' => $active,
				'nonActive' => $nonActive,
				'history' => $history,
			);
			
			return response()->json($orders, 200);
		} catch (\Exception $e) {
			return response()->json($e->getMessage(), 500);
		}
	}
	
	public function userGetQuotedPrice($id) {
		try {
// 			$user = auth()->user();
			$user = new \stdClass();
			$user->id = 194;
			
			// check order state
			$order = Order::api_getOrder($id, $user->id);
			if ($order->state !== Config::get('constants.ORD_NEW')) {
				return response()->json('', 400);
			}
			
			// get quoted price list
			$quotedPrice = QuotedPrice::api_getQuotedPriceByOrder($id);
			if (sizeof($quotedPrice) > 0) {
				return response()->json($quotedPrice, 200);
			}
			
			return response()->json('', 204);
		} catch (\Exception $e) {
			return response()->json($e->getMessage(), 500);
		}
	}

	public function userAcceptQuotedPrice($id, $proId) {
		try {
			// user = auth()->user();
			$user = new \stdClass();
			$user->id = 194;
			
			// check order state
			$order = Order::api_getOrder($id, $user->id);
			if ((!$order) || $order->state !== Config::get('constants.ORD_NEW')) {
				return response()->json('', 400);
			}
			
			// get accepted quoted price
			$quotedPrice = QuotedPrice::api_getQuotedPriceByOrderAndPro($id, $proId);
			if (!$quotedPrice) {
				return response()->json('', 400);
			}
			
			// update order
			$order = Order::find($id);
			$order->total_price = $quotedPrice->price;
			$order->state = Config::get('constants.ORD_ACCEPTED');
			$order->pro_id = $quotedPrice->pro_id;
			if (!$order->est_excute_at) {
				$order->est_excute_at = date('Y-m-d H:i', strtotime('+'.env('ASAP_EXCUTE_DATE').'minutes'));
				$order->est_excute_at_string = CommonController::getStringAsapExcuteDateTime();
			}
			
			// excute
			DB::beginTransaction();
			$order->save();
			QuotedPrice::api_acceptQuotedPrice($id, $proId);
			QuotedPrice::api_rejectQuotedPrice($id, $proId);
			DB::commit();
			
			// TODO: send noti to pros
			
			return response()->json('', 200);
		} catch (\Exception $e) {
			DB::rollback();
			return response()->json($e->getMessage(), 500);
		}
	}

	public function userCancel($id) {
		try {
			// user = auth()->user();
			$user = new \stdClass();
			$user->id = 194;
			
			// check order state
			$order = Order::api_getOrder($id, $user->id);
			if ((!$order) || $order->state === Config::get('constants.ORD_COMPLETE')) {
				return response()->json('', 400);
			}
			
			$order = Order::find($id);
			$order->state = Config::get('constants.ORD_CANCEL');
			
			// excute
			DB::beginTransaction();
			$order->save();
			QuotedPrice::api_rejectQuotedPrice($id);
			DB::commit();
			
			// TODO: send noti to pros
			
			return response()->json('', 200);
		} catch (\Exception $e) {
			DB::rollback();
			return response()->json($e->getMessage(), 500);
		}
	}

	public function userGetOrder($id) {
		try {
			// user = auth()->user();
			$user = new \stdClass();
			$user->id = 194;
			
			$order = Order::api_getOrder($id, $user->id);
			$order->requirements = json_decode($order->requirements);
			if ($order) {
				return response()->json($order, 200);
			}
			
			return response()->json('', 400);
		} catch (\Exception $e) {
			return response()->json($e->getMessage(), 500);
		}
	}

	public function create(Request $request) {
		try {
			// $user = auth()->user();
			$user = new \stdClass();
			$user->id = 194;
			$user = User::find($user->id);
			
			$order = new Order();
			$order->user_id = $user->id;
			$order->user_name = $user->name;
			$order->user_email = $user->email;
			$order->user_phone = $user->phone;
			
			$order->service_id = $request->service;
			
			// TODO: change array
			$order->requirements = json_encode($request->survey);
			
			$order->address = $request->locationText;
			$order->address_2 = $request->locationText2;
			
			$order->location = $request->region['latitude'] . ',' . $request->region['longitude'];
			
			if ($request->timeStyle == '1') {
				$order->est_excute_at = CommonController::convertDatetimeFromApp($request->time);
				$order->est_excute_at_string = $request->timeString;
			}
			
			$order->promo_code = $request->promoCode;
			
			$order->save();
			Order::setOrderNo($order->id, CommonController::getOrderNo($order));
			
			return response()->json('', 200);
		} catch (\Exception $e) {
			return response()->json($e->getMessage(), 500);
		}
	}
}
