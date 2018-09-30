<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
	// table name
	protected $table = 'wallet_transaction';
	
	public function getListForMng() {
		return $this::with('walletInfo', 'createdInfo')
			->get();
	}
	
	public function walletInfo() {
		return $this->hasOne('App\User', 'id', 'wallet_id')
			->select(['id', 'name']);
	}
	
	public function createdInfo() {
		return $this->hasOne('App\User', 'id', 'created_by')
			->select(['id', 'name']);
	}
}
