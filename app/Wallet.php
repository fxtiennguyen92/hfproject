<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Wallet extends Model
{
	// table name
	protected $table = 'wallets';
	
	protected $fillable = ['id', 'wallet_1', 'wallet_2', 'wallet_3', 'style', 'delete_flg', 'created_at', 'updated_at'];
	
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
