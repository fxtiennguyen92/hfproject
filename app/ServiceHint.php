<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class ServiceHint extends Model
{
	protected $table = 'service_hints';

	public static function getPopular() {
		return ServiceHint::select(['id', 'hint as name'])
			->popular()
			->get();
	}

	public function scopePopular($query) {
		return $query->where('popular_flg', Config::get('constants.FLG_ON'));
	}
}
