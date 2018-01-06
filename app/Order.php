<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	// table name
	protected $table = 'orders';

	public function getById($id) {
		$order = $this->where('id', $id)->first();
		
		if (!$order) {
			return null;
		}

		$order->requirements = json_decode($order->requirements);
		return $order;
	}
}
