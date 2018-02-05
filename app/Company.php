<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Company extends Model
{
	// table name
	protected $table = 'companies';
	
	/**
	 * Get name of companies to show by dropdown
	 * 
	 * @return array
	 */
	public function autocompleteByName($input) {
		return $this
			->where('name','LIKE', '%'.$input.'%')
			->orWhere('id', 'LIKE', '%'.$input.'%')
			->available()->select('id', 'name', 'address')
			->get();
	}

	public function getAll() {
		return $this->available()->get();
	}

	public function scopeAvailable($query) {
		return $query->where('delete_flg', Config::get('constants.FLG_OFF'));
	}
}
