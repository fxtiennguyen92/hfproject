<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TempPro extends Model
{
	protected $table = 'temp_pros';

	public function getAllForMng() {
		return $this::get();
	}

	public function getAllForPA($id) {
		return $this::with('user')
			->where('created_by', $id)
			->get();
	}
	
	public function user() {
		return $this->hasOne('App\User', 'phone', 'phone');
	}
	
	public static function existPhone($phone, $id = null) {
		if (!$phone) {
			return false;
		}
		
		$pro = TempPro::where('phone', $phone)->first();
		
		if (!$pro) {
			return false;
		}
		
		if ($pro->id === $id) {
			return false;
		}
		
		return true;
	}
}
