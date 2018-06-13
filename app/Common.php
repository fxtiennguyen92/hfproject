<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Common extends Model
{
	// table name
	protected $table = 'commons';

	public function getByKey($key) {
		return $this
			->where('key', $key)
			->available()
			->orderBy('order_dsp')
			->orderBy('name')
			->get();
	}

	public function getInitByKey($key) {
		return $this
			->where('key', $key)
			->where('init_flg', Config::get('constants.FLG_ON'))
			->available()
			->first();
	}

	public function getByCode($code) {
		return $this
			->where('code', $code)
			->available()
			->first();
	}

	public function getByKeyAndValue($key, $value) {
		return $this
			->where('key', $key)
			->where('value', $value)
			->available()
			->orderBy('order_dsp')
			->orderBy('name')
			->get();
	}
	
	public function getAllByKey($key) {
		return $this
			->where('key', $key)
			->get();
	}

	public static function updateDeleteFlg($key, $code, $deleteFlg) {
		Common::where('key', $key)
			->where('code', $code)
			->update(['delete_flg' => $deleteFlg]);
	}

	public function scopeAvailable($query) {
		return $query->where('delete_flg', Config::get('constants.FLG_OFF'));
	}

	/**
	 * Get city list by ajax
	 */
	public function getCityList() {
		return $this->getByKey(Config::get('constants.KEY_CITY'));
	}

	/**
	 * Get district list by ajax
	 */
	public function getDistList($cityCode = null) {
		if (!$cityCode) {
			$initCity = $this->getInitByKey(Config::get('constants.KEY_CITY'));
			
			$cityCode = '';
			if ($initCity) {
				$cityCode = $initCity->code;
			} else {
				$cityCode = $this->getCityList()->first()->code;
			}
		}
		
		return $this->getByKeyAndValue(Config::get('constants.KEY_DIST'), $cityCode);
	}
}
