<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
	// table name
	protected $table = 'reviews';

	public function get($id) {
		return $this->where('id', $id)
			->first();
	}
	
	public function getByPro($proId) {
		return $this::with('user')
			->where('to_id', $proId)
			->get();
	}
	
	public function user() {
		return $this->hasOne('App\User', 'id', 'from_id');
	}
}
