<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Common extends Model
{
	// table name
	protected $table = 'commons';

	public function getByKey($key) {
		return $this->where('key', $key)->available()->get();
	}

	public function getByCode($code) {
		return $this->where('code', $code)->available()->get();
	}

	public function scopeAvailable($query) {
		return $query->where('delete_flg', '=', Config::get('constants.FLG_OFF'));
	}
}
