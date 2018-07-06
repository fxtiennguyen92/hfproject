<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class DiscountCode extends Model
{
	// table name
	protected $table = 'discount_codes';

	public function getUseableCodesByCode($searchCode, $role) {
		return $this
			->where('code', $searchCode)
			->where('user_role', $role)
			->active()
			->orderBy('code')
			->get();
	}
	
	public function scopeActive($query) {
		return $query
			->where('active_flg', Config::get('constants.FLG_ON'))
			->where(function ($query) {
				$query->where('quantity', '>', '0')
					->orWhereNull('quantity');
				})
			->where(function ($query) {
				$query->whereDate('expire_date', '<=', date('Y-m-d'))
					->orWhereNull('expire_date');
				});
	}
}
