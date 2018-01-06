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
}
