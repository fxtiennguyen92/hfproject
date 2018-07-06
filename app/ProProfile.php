<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ProProfile extends Model
{
	// table name
	protected $table = 'pro_profiles';
	
	public function getById($id) {
		return $this->where('id', $id)->first();
	}
	
	public static function updateState($id, $state) {
		return ProProfile::where('id', $id)
			->update(['state' => $state]);
	}
	
	public static function updateInspection($id, $inspection) {
		return ProProfile::where('id', $id)
			->update(['inspection' => $inspection]);
	}
	
	public function user() {
		return $this->hasOne('App\User', 'id', 'id');
	}
	
	public function company() {
		return $this->hasOne('App\Company', 'id', 'company_id');
	}
	
	public function reviews() {
		return $this->hasMany('App\Review', 'to_id', 'id');
	}
	
	public function district_info() {
		return $this->hasOne('App\Common', 'code', 'district');
	}
	
	public function city_info() {
		return $this->hasOne('App\Common', 'code', 'city');
	}
	
	public function getAgeAttribute() {
		return Carbon::parse($this->attributes['date_of_birth'])->age;
	}
}
