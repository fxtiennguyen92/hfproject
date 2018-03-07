<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
	
	public function user() {
		return $this->hasOne('App\User', 'id', 'id');
	}
}
