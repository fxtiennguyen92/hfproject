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
		return $this::with('profile')
			->proAndProManager()
			->get();
	}

	public function getPro($proId) {
		return $this::with('profile')
			->where('id', $proId)
			->pro()
			->get();
	}

	public function getProsByProManager($proManagerId) {
		return $this::with('profile')
			->where('created_by', $proManagerId)
			->pro()
			->available()
			->get();
	}
	
	public function getProByProManager($proId, $proManagerId) {
		return $this::with('profile')
			->where('id', $proId)
			->where('created_by', $proManagerId)
			->pro()
			->available()
			->get();
	}

	public function updateDeleteFlg ($id, $deleteFlg) {
		return User::where('id', $id)->update([
				'delete_flg' => $deleteFlg
			]);
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
	
	public function scopeProManager($query) {
		return $query->where('role', Config::get('constants.ROLE_PRO_MNG'));
	}
	
	public function scopeProAndProManager($query) {
		return $query->where('role', Config::get('constants.ROLE_PRO_MNG'))
					->orWhere('role', Config::get('constants.ROLE_PRO'));
	}
	
	public function scopeAvailable($query) {
		return $query->where('delete_flg', Config::get('constants.FLG_OFF'));
	}
}
