<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WalletTransactionRequest extends Model
{
	protected $table = 'wallet_transaction_requests';
	
	public static function getByUser($id) {
		return WalletTransactionRequest::where('wallet_id', $id)
			->get();
	}
	
	public static function getListForMng() {
		return WalletTransactionRequest::with('walletInfo')
			->get();
	}
	
	public function walletInfo() {
		return $this->hasOne('App\User', 'id', 'wallet_id');
	}
}
