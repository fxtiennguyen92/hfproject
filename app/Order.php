<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Order extends Model
{
	// table name
	protected $table = 'orders';

	public function getById($id) {
		$order = $this->where('id', $id)->first();
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
			->whereNotIn('id', QuotedPrice::getListQuotedOrderIdByPro($id))
			->get();
	}

	public function getQuotedByPro($id) {
		return $this
			->new()
			->whereIn('id', QuotedPrice::getListQuotedOrderIdByPro($id))
			->get();
	}

	public function scopeNew($query) {
		return $query->where('state', Config::get('constants.ORD_NEW'));
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
