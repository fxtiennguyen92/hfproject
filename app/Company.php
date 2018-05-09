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

	public function get($id) {
		return $this
			->where('id', $id)
			->available()
			->first();
	}

	public function getAll() {
		return $this->available()->get();
	}

	public function existPhone($phone, $id = null) {
		if (!$phone) {
			return false;
		}
		
		$comp = $this
			->where('phone_1', $phone)
			->orWhere('phone_2', $phone)
			->first();
		
		if (!$comp) {
			return false;
		}
		
		if ($comp->id === $id) {
			return false;
		}
		
		return true;
	}

	public function scopeAvailable($query) {
		return $query->where('delete_flg', Config::get('constants.FLG_OFF'));
	}
}
