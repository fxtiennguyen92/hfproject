<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Doc extends Model
{
	// table name
	protected $table = 'docs';
	
	protected $fillable = [
					'id', 'url_name', 'title', 'content'
	];

	public function getByUrlName($urlName) {
		return $this
			->where('url_name', $urlName)
			->available()
			->first();
	}
	
	public function getAllForMng() {
		return $this->get();
	}

	public function scopeAvailable($query) {
		return $query->where('delete_flg', Config::get('constants.FLG_OFF'));
	}
}
