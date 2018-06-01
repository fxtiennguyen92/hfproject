<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Wallet extends Model
{
	// table name
	protected $table = 'wallets';
	
	public function getById($id) {
		return $this
			->where('id', $id)
			->available()
			->first();
	}
	
	public function scopeAvailable($query) {
		return $query->where('delete_flg', Config::get('constants.FLG_OFF'));
	}
}
