<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable implements JWTSubject
{
	use Notifiable;

	protected $fillable = [
		'name', 'email', 'phone', 'password', 'password_temp', 'role', 'delete_flg',
		'confirm_code', 'confirm_flg', 'google_id', 'facebook_id', 'avatar',
		'device_token', 'created_at'
	];

	protected $hidden = [
		'password', 'remember_token',
	];

	public function getAvailableAcc($id) {
		return $this::with('wallet', 'profile', 'profile.company', 'profile.reviews', 'walletTransactionRequest')
			->where('id', $id)
			->available()
			->first();
	}

	public function getAccByPhone($phone) {
		return $this
			->where('phone', $phone)
			->first();
	}

	public function getAllUserForMng() {
		return $this
			->user()
			->get();
	}

	public function getAllProForMng() {
		return $this::with('profile', 'profile.company', 'profile.district_info', 'profile.city_info', 'wallet')
			->proAndProManager()
			->get();
	}

	public function getAllProForPA($paId) {
		return $this::with('profile', 'profile.company')
			->where('created_by', $paId)
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
		return $this::with('profile')
			->where('id', $proId)
			->pro()
			->first();
	}

	public function getProsForProManager($proManagerId) {
		return $this::with('profile')
			->where('created_by', $proManagerId)
			->pro()
			->available()
			->get();
	}

	public function getAllPAForMng() {
		return $this::with('profile', 'proCount')
			->pa()
			->get();
	}

	public function reportNewProCountByMonth($from, $end) {
		return DB::table('users')
			->select(
				DB::raw('count(id) data'),
				DB::raw('DATE_FORMAT(created_at, "%Y%m") as yearmonth')
			)
			->where('role', Config::get('constants.ROLE_PRO'))
			->where('created_at', '>=', $from)
			->where('created_at', '<=', $end)
			->groupBy('yearmonth')
			->orderBy('yearmonth')
			->get();
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
		
		if ($user->id === $id) {
			return false;
		}
		
		return true;
	}

	public function existEmail($email, $id = null) {
		if (!$email) {
			return false;
		}
		
		$user = $this
			->where('email', $email)
			->first();
		
		if (!$user) {
			return false;
		}
		
		if ($user->id === $id) {
			return false;
		}
		
		return true;
	}

	public function activeProAccount($id) {
		$passwordTemp = str_random(6);
		return User::where('id', $id)
		->update([
						'password_temp' => $passwordTemp,
						'password' => bcrypt($passwordTemp),
						'confirm_flg' => Config::get('constants.FLG_ON'),
						'delete_flg' => Config::get('constants.FLG_OFF'),
		]);
	}

	public function updateDeleteFlg($id, $deleteFlg) {
		return User::where('id', $id)
		->update([
						'delete_flg' => $deleteFlg
		]);
	}

	public function updatePassword($id, $password = null) {
		if (!$password) {
			$passwordNew = str_random(6);
			return User::where('id', $id)
			->update([
							'password' => bcrypt($passwordNew),
							'password_temp' => $passwordNew,
			]);
		} else {
			return User::where('id', $id)
			->update([
							'password' => bcrypt($password),
							'password_temp' => null,
			]);
		}
	}

	public function updatePhone($id, $phone) {
		return User::where('id', $id)
		->update([
						'phone' => $phone,
		]);
	}

	public function updateName($id, $name) {
		return User::where('id', $id)
		->update([
						'name' => $name,
		]);
	}

	public function updateEmail($id, $email, $confirmCode) {
		return User::where('id', $id)
		->update([
						'email' => $email,
						'confirm_code' => $confirmCode,
						'confirm_flg' => Config::get('constants.FLG_OFF')
		]);
	}

	public static function checkLoginAccount($account) {
		// get with username is phone
		$user = User::where('phone', $account->username)
			->orWhere('email', $account->username)
			->first();
		
		if ($user) {
			// check password
			if (Hash::check($account->password, $user->password)) {
				return $user;
			}
		}
		
		return null;
	}

	public function profile() {
		return $this->hasOne('App\ProProfile', 'id');
	}
	
	public function wallet() {
		return $this->hasOne('App\Wallet', 'id');
	}
	
	public function walletTransactionRequest() {
		return $this->hasMany('App\WalletTransactionRequest', 'id')
			->orderBy('created_at');
	}
	
	public function scopeUser($query) {
		return $query->where('role', Config::get('constants.ROLE_USER'));
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
	
	public function scopePa($query) {
		return $query->where('role', Config::get('constants.ROLE_PA'));
	}
	
	public function scopeAvailable($query) {
		return $query->where('delete_flg', Config::get('constants.FLG_OFF'));
	}
	
	public function getPLevelAttribute() {
		$commonModel = new Common();
		$levels = $commonModel->getByKey(Config::get('constants.KEY_POINT_LEVEL'));
		
		$pointLevel = 0;
		foreach ($levels as $key=>$level) {
			if ($level->value < $this->attributes['point']) {
				$pointLevel = $key;
			}
		}
		
		return $pointLevel;
	}
	
	public function proCount() {
		return $this->hasMany('App\ProProfile', 'created_by', 'id')
			->selectRaw('created_by, count(*) as count')
			->groupBy('created_by');
	}
	
	/*=== API ===*/
	public function getJWTIdentifier() {
		return $this->getKey();
	}
	public function getJWTCustomClaims() {
		return [];
	}
	
	public static function api_getUserByPhone($phone) {
		return User::where('phone', $phone)
			->user()
			->available()
			->first();
	}
	
	public static function api_getUserByFacebookAccount($email, $facebookId) {
		return User::where('facebook_id', $facebookId)
			->orWhere('email', $email)
			->user()
			->available()
			->first();
	}
	
	public static function api_getUserByGoogleAccount($email, $googleId) {
		return User::where('google_id', $googleId)
			->orWhere('email', $email)
			->user()
			->available()
			->first();
	}
	
	/* PRO */
	public static function api_getProBasicInfo($id) {
		return User::select('id', 'name', 'avatar')
			->with([
				'profile' => function($query) {
					$query->select('date_of_birth', 'gender', 'rating', 'total_review', 'total_orders');
				}
			])
			->where('id', $id)
			->pro()
			->available()
			->first();
	}
}
