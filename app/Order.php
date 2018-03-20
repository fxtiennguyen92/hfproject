<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Order extends Model
{
	// table name
	protected $table = 'orders';

	public function getById($id) {
		return $this::with('user', 'service')
			->where('id', $id)
			->first();
	}

	public function getTempById($id) {
		return $this::with('user', 'service')
			->where('id', $id)
			->temp()
			->first();
	}

	public function getByUser($id) {
		return $this->where('user_id', $id)->get();
	}

	public function getByPro($id) {
		return $this->where('pro_id', $id)->get();
	}

	public function getNewByPro($id) {
		return $this
			->new()
			->whereNotIn('id', QuotedPrice::getListNewQuotedOrderIdByPro($id))
			->get();
	}

	public function getQuotedByPro($id) {
		return $this
			->new()
			->whereIn('id', QuotedPrice::getListNewQuotedOrderIdByPro($id))
			->get();
	}

	public function getNewByMember($id) {
		return $this::with('service')
			->new()
			->where('user_id', $id)
			->get();
	}

	public function getNewAndNoQuotedPriceByMember($id) {
		return $this
			->new()
			->where('user_id', $id)
			->where('quoted_price_count', 0)
			->get();
	}

	public function getNewAndQuotedPriceByMember($id) {
		return $this
			->new()
			->where('user_id', $id)
			->where('quoted_price_count','>', 0)
			->get();
	}

	public function getProcessingByMember($id) {
		return $this::with('pro', 'pro_profile')
			->processing()
			->where('user_id', $id)
			->get();
	}

	public static function acceptQuotedPrice($order) {
		return Order::where('id', $order->id)
			->update([
					  'pro_id' => $order->pro_id
					, 'est_excute_at' => $order->est_excute_at
					, 'est_excute_at_string' => $order->est_excute_at_string
					, 'total_price' => $order->total_price
					, 'state' => $order->state
			]);
	}

	public static function updateState($orderId, $state) {
		return Order::where('id', $orderId)
			->update(['state' => $state]);
	}

	public static function setOrderNo($orderId, $orderNo) {
		return Order::where('id', $orderId)
			->update(['no' => $orderNo]);
	}
	

	public function service() {
		return $this->hasOne('App\Service', 'id', 'service_id');
	}

	public function user() {
		return $this->hasOne('App\User', 'id', 'user_id');
	}

	public function pro() {
		return $this->hasOne('App\User', 'id', 'pro_id');
	}

	public function pro_profile() {
		return $this->hasOne('App\ProProfile', 'id', 'pro_id');
	}

	public function scopeTemp($query) {
		return $query
			->where('state', Config::get('constants.ORD_NEW'))
// 			->whereNull('no')
			->orderBy('created_at', 'desc');
	}

	public function scopeNew($query) {
		return $query
			->where('state', Config::get('constants.ORD_NEW'))
			->whereNotNull('no')
			->orderBy('created_at', 'desc');
	}

	public function scopeProcessing($query) {
		return $query->where('state', Config::get('constants.ORD_PROCESSING'))->orderBy('created_at', 'desc');
	}
	
	public function scopeComplete($query) {
		return $query->where('state', Config::get('constants.ORD_COMPLETE'))->orderBy('created_at', 'desc');
	}
	
	public function scopeCancel($query) {
		return $query->where('state', Config::get('constants.ORD_CANCEL'))->orderBy('created_at', 'desc');
	}
}
