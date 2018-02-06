<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Config;

class User extends Authenticatable
{
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'phone', 'password', 'role', 'delete_flg',
		'confirm_code', 'confirm_flg',
		'google_id', 'facebook_id', 'avatar'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	public function getAllPro() {
		return $this::with('profile')->pro()->get();
	}

	public function profile() {
		return $this->hasOne('App\ProProfile', 'id');
	}
	
	public static function getAvatar($id) {
		return User::select('avatar')->where('id', $id)->first();
	}
	
	public function scopeMember($query) {
		return $query->where('role', Config::get('constants.ROLE_MEM'));
	}

	public function scopePro($query) {
		return $query->where('role', Config::get('constants.ROLE_PRO'));
	}
}
