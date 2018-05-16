<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
	// table name
	protected $table = 'materials';

	public function get($id) {
		return $this->where('id', $id)
			->available()
			->first();
	}
	
	/**
	 * Get all for view customer page
	 * 
	 * @param string $orderCol
	 * @param string $sorting
	 * @return unknown
	 */
	public function getAll() {
		return $this
			->available()
			->orderBy('name')
			->get();
	}

	public function scopeAvailable($query) {
		return $query->where('delete_flg', 0);
	}
}
