<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class QuotedPrice extends Model
{
	// table name
	protected $table = 'quoted_prices';
	
	protected $fillable = [
		'id','order_id', 'pro_id', 'price',
	];
	
	public function getById($id) {
		return $this->where('id', $id)->first();
	}

	public function getByOrder($id) {
		return $this->where('order_id', $id)->get();
	}
	
	public function getNewByPro($id) {
		return $this::with('order')
			->where('pro_id', $id)
			->new()
			->get();
	}
	
	public static function getListNewQuotedOrderIdByPro($id) {
		return QuotedPrice::where('pro_id', $id)
				->new()
				->pluck('order_id')
				->toArray();
	}
	
	public function order() {
		return $this->hasOne('App\Order', 'id', 'order_id');
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
