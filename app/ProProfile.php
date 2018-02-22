<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProProfile extends Model
{
	// table name
	protected $table = 'pro_profiles';
	
	/**
	 * Get profile by id
	 * 
	 * @return array
	 */
	public function getById($id) {
		return $this->where('id', $id)->first();
	}
	
	public function user() {
		return $this->hasOne('App\User', 'id', 'id');
	}
}
