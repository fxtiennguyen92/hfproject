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
		return $this->where('code', $code)->available()->first();
	}

	public function getByKeyAndValue($key, $value) {
		return $this
			->where('key', $key)
			->where('value', $value)
			->available()
			->get();
	}

	public function scopeAvailable($query) {
		return $query->where('delete_flg', Config::get('constants.FLG_OFF'));
	}

	public function getCityList() {
		return $this->getByKey(Config::get('constants.KEY_CITY'));
	}

	public function getDistList($cityCode) {
		return $this->getByKeyAndValue(Config::get('constants.KEY_DIST'), $cityCode);
	}
}
