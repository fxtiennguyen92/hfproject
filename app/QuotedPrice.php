<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class QuotedPrice extends Model
{
	// table name
	protected $table = 'quoted_prices';
	
	protected $fillable = [
		'qp_id', 'order_id', 'pro_id', 'price', 'introduction', 'est_excute_at', 'est_excute_at_string',
	];
	
	public function getById($id) {
		return $this->where('qp_id', $id)->first();
	}

	public function getByOrder($id) {
		return $this::with('pro', 'pro_profile')
			->where('order_id', $id)
			->new()
			->get();
	}
	
	public function getByPro($id) {
		return $this::with('order')
			->where('pro_id', $id)
			->orderBy('updated_at', 'desc')
			->get();
	}
	
	public static function getListNewQuotedOrderIdByPro($id) {
		return QuotedPrice::where('pro_id', $id)
				->new()
				->pluck('order_id')
				->toArray();
	}
	
	public static function updateState($qpId, $state) {
		return QuotedPrice::where('qp_id', $qpId)
			->update(['state' => $state]);
	}
	
	public function order() {
		return $this->hasOne('App\Order', 'id', 'order_id');
	}
	
	public function pro_profile() {
		return $this->hasOne('App\ProProfile', 'id', 'pro_id');
	}
	
	public function pro() {
		return $this->hasOne('App\User', 'id', 'pro_id');
	}
	
	public function scopeNew($query) {
		return $query->where('state', Config::get('constants.QPRICE_NEW'));
	}
	
	public function scopeSuccess($query) {
		return $query->where('state', Config::get('constants.QPRICE_SUCCESS'));
	}
	
	public function scopeFailed($query) {
		return $query->where('state', Config::get('constants.QPRICE_FAILED'));
	}
}
