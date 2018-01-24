<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
	
	public static function getListQuotedOrderIdByPro($id) {
		return QuotedPrice::where('pro_id', $id)->pluck('order_id')->toArray();
	}
}
