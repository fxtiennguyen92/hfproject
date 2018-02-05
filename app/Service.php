<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
	// table name
	protected $table = 'services';

	public function get($id) {
		return $this->where('id', $id)
			->available()
			->first();
	}
	
	public function getAll() {
		return $this->available()->get();
	}

	public function scopeAvailable($query) {
		return $query->where('delete_flg', 0);
	}
}
