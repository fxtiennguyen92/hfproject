<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Order extends Model
{
	// table name
	protected $table = 'orders';

	public function getById($id) {
		$order = $this::with('user')->where('id', $id)->first();
		if ($order) {
			$common = new Common();
			$order->city_string = $common->getByCode($order->city)->name;
			$order->dist_string = $common->getByCode($order->district)->name;
			
			return $order;
		}
		
		return null;
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
			->get();
	}

	public function getNewAndNoQuotedPriceByMember($id) {
		return $this
			->new()
			->where('quoted_price_count', 0)
			->get();
	}

	public function getNewAndQuotedPriceByMember($id) {
		return $this
			->new()
			->where('quoted_price_count','>', 0)
			->get();
	}

	public function getProcessingByMember($id) {
		return $this::with('pro', 'pro_profile')
			->processing()
			->get();
	}

	public static function acceptQuotedPrice($order) {
		return Order::where('id', $order->id)
			->update([
					  'est_excute_at' => $order->est_excute_at
					, 'total_price' => $order->total_price
					, 'state' => $order->state
			]);
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

	public function scopeNew($query) {
		return $query->where('state', Config::get('constants.ORD_NEW'))->orderBy('created_at', 'desc');
	}

	public function scopeProcessing($query) {
		return $query->where('state', Config::get('constants.ORD_PROCESSING'));
	}
	
	public function scopeComplete($query) {
		return $query->where('state', Config::get('constants.ORD_COMPLETE'));
	}
	
	public function scopeCancel($query) {
		return $query->where('state', Config::get('constants.ORD_CANCEL'));
	}
}
