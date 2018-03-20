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
	
	public function getFromArray($arr) {
		return $this->whereIn('id', $arr)
			->available()
			->get();
	}
	
	public function getByIdOrUrlName($string) {
		return $this->where('id', $string)
			->orWhere('url_name', $string)
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
