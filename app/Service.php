<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Service extends Model
{
	// table name
	protected $table = 'services';

	public function get($id) {
		return $this->where('id', $id)
			->available()
			->first();
	}
	
	public function getFromArray($arr) {
		return $this->whereIn('id', $arr)
			->serving()
			->available()
			->get();
	}
	
	public function getByIdOrUrlName($string) {
		return $this->where('id', $string)
			->orWhere('url_name', $string)
			->serving()
			->available()
			->first();
	}
	
	public function getAll() {
		return $this
			->available()
			->get();
	}
	
	public function getAllServing() {
		return $this
			->serving()
			->available()
			->get();
	}

	public function scopeServing($query) {
		return $query->where('serve_flg', Config::get('constants.FLG_ON'));
	}

	public function scopeAvailable($query) {
		return $query->where('delete_flg', Config::get('constants.FLG_OFF'));
	}
}
