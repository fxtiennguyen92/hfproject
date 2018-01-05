<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProProfile extends Model
{
	// table name
	protected $table = 'pro_profiles';
	
	protected $fillable = [
		'id', 'gender','date_of_birth'
	];
	
	/**
	 * Get profile by id
	 * 
	 * @return array
	 */
	public function getById($id) {
		return $this->where('id', $id)->first();
	}
}
