<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

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

	public function getAllAcc() {
		return $this->get();
	}

	public function getAllProForMng() {
		return $this::with('profile', 'profile.company', 'profile.district_info', 'profile.city_info')
			->proAndProManager()
			->get();
	}

	public function getAllProForPA() {
		return $this::with('profile', 'profile.company')
			->proAndProManager()
			->available()
			->orderBy('updated_at', 'desc')
			->get();
	}

	public function getProOrProManager($proId) {
		return $this::with('profile', 'profile.company')
			->where('id', $proId)
			->proAndProManager()
			->first();
	}

	public function getPro($proId) {
		$pro = $this::with('profile')
			->where('id', $proId)
			->pro()
			->first();
		if (!$pro) {
			return null;
		}
		
		if ($pro->profile->services) {
			$serviceModel = new Service();
			$pro->services = $serviceModel->getFromArray(json_decode($pro->profile->services));
		}
		return $pro;
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
			->first();
	}

	public function existPhone($phone, $id = null) {
		if (!$phone) {
			return false;
		}
		
		$user = $this
			->where('phone', $phone)
			->first();
		
		if (!$user) {
			return false;
		}
		
		if ($comp->id === $id) {
			return false;
		}
		
		return true;
	}

	public function activeProAccount($id) {
		$passwordTemp = str_random(12);
		return User::where('id', $id)->update([
						'password_temp' => $passwordTemp,
						'password' => bcrypt($passwordTemp),
						'confirm_flg' => Config::get('constants.FLG_ON'),
						'delete_flg' => Config::get('constants.FLG_OFF')
		]);
	}

	public function updateDeleteFlg($id, $deleteFlg) {
		return User::where('id', $id)->update([
						'delete_flg' => $deleteFlg
		]);
	}

	public function updatePassword($id, $password) {
		return User::where('id', $id)->update([
						'password' => bcrypt($password)
		]);
	}

	public static function checkLoginAccount($account) {
		// get with username is phone
		$user = User::where('phone', $account->username)
			->available()
			->first();
		
		if (!$user) {
			// get with username is email
			$user = User::where('email', $account->username)
				->available()
				->first();
		}
		
		if (!$user) {
			return null;
		}
		
		// check password
		if (!(Hash::check($account->password, $user->password))) {
			return null;
		}
		
		return $user;
	}

	public function profile() {
		return $this->hasOne('App\ProProfile', 'id');
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
