<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
	// table name
	protected $table = 'orders';

	public function getAll($fromDate = null, $endDate = null) {
		return $this::with('user', 'pro', 'service')
			->where('created_at', '>=', $fromDate)
			->where('created_at', '<=', $endDate)
			->get();
	}

	public function getById($id) {
		return $this::with('user', 'pro', 'service')
			->where('id', $id)
			->first();
	}

	public function getByNo($no) {
		return $this
			->where('no', $no)
			->first();
	}

	public function getNewById($id) {
		return $this::with('user', 'service')
			->where('id', $id)
			->new()
			->first();
	}

	public function getByIdAndUserId($id, $userId) {
		return $this::with('user', 'service', 'questions')
			->where('id', $id)
			->where('user_id', $userId)
			->first();
	}

	public function getByUser($id) {
		return $this->where('user_id', $id)->get();
	}

	public function getByPro($id) {
		return $this->where('pro_id', $id)->get();
	}

	public function getNewByPro($id, $services) {
		$date = new \DateTime();
		$date->modify('-24 hours');
		$min_date = $date->format('Y-m-d H:i:s');
		
		return $this
			->new()
			->whereIn('service_id', json_decode($services))
			->whereNotIn('id', QuotedPrice::getListNewQuotedOrderIdByPro($id))
			->where('created_at', '>', $min_date)
			->get();
	}

	public function getQuotedByPro($id) {
		return $this
			->new()
			->whereIn('id', QuotedPrice::getListNewQuotedOrderIdByPro($id))
			->get();
	}

	public function getNewByMember($id) {
		return $this::with('service')
			->new()
			->where('user_id', $id)
			->get();
	}

	public function getNewAndNoQuotedPriceByMember($id) {
		return $this
			->new()
			->where('user_id', $id)
			->where('quoted_price_count', 0)
			->get();
	}

	public function getNewAndQuotedPriceByMember($id) {
		return $this
			->new()
			->where('user_id', $id)
			->where('quoted_price_count','>', 0)
			->get();
	}

	public function getCurrentByMember($id) {
		return $this::with('pro', 'pro.profile', 'quotedPrice', 'quotedPrice.pro')
			->current()
			->where('user_id', $id)
			->get();
	}

	
	public function reportOrderCountByMonth($from, $end) {
		return DB::table('orders')
			->select(
				DB::raw('count(id) data'),
				DB::raw('DATE_FORMAT(created_at, "%Y%m") as yearmonth')
			)
			->where('created_at', '>=', $from)
			->where('created_at', '<=', $end)
			->groupBy('yearmonth')
			->orderBy('yearmonth')
			->get();
	}
	
	public function reportOrderValueByMonth($from, $end) {
		return DB::table('orders')
			->select(
				DB::raw('sum(order_value) data'),
				DB::raw('DATE_FORMAT(created_at, "%Y%m") as yearmonth')
			)
			->where('created_at', '>=', $from)
			->where('created_at', '<=', $end)
			->groupBy('yearmonth')
			->orderBy('yearmonth')
			->get();
	}
	
	public function reportWorkProByMonth($from, $end) {
		return DB::select('
			SELECT
				  COUNT(temp.pro_id) data
				, temp.yearmonth
			FROM (
				SELECT
					  DISTINCT pro_id
					, DATE_FORMAT(created_at, "%Y%m") yearmonth
				FROM orders
				WHERE pro_id IS NOT NULL
				AND created_at >= :from
				AND created_at <= :end
				ORDER BY yearmonth
			) temp
			GROUP BY temp.yearmonth
		', ['from' => $from, 'end' => $end]);
	}
	
	public function reportUsingUserByMonth($from, $end) {
		return DB::select('
			SELECT
				  COUNT(temp.user_id) data
				, temp.yearmonth
			FROM (
				SELECT
					  DISTINCT user_id
					, DATE_FORMAT(created_at, "%Y%m") yearmonth
				FROM orders
				WHERE created_at >= :from
				AND created_at <= :end
				ORDER BY yearmonth
			) temp
			GROUP BY temp.yearmonth
		', ['from' => $from, 'end' => $end]);
	}
	
	public static function acceptQuotedPrice($order) {
		return Order::where('id', $order->id)
			->update([
					'pro_id' => $order->pro_id,
					'est_excute_at' => $order->est_excute_at,
					'est_excute_at_string' => $order->est_excute_at_string,
					'total_price' => $order->total_price,
					'state' => $order->state,
			]);
	}

	public static function updateState($orderId, $state) {
		Order::where('id', $orderId)
			->update(['state' => $state]);
	}

	public static function setOrderNo($orderId, $orderNo) {
		Order::where('id', $orderId)
			->update(['no' => $orderNo]);
	}

	public static function deleteOrderTemp($orderId) {
		$order = Order::find($orderId);
		$order->delete();
	}

	public function service() {
		return $this->hasOne('App\Service', 'id', 'service_id');
	}

	public function questions() {
		return $this->hasMany('App\Survey', 'service_id', 'service_id');
	}

	public function user() {
		return $this->hasOne('App\User', 'id', 'user_id');
	}

	public function pro() {
		return $this->hasOne('App\User', 'id', 'pro_id');
	}

	public function quotedPrice() {
		return $this->hasMany('App\QuotedPrice', 'order_id', 'id');
	}
	
	public function review() {
		return $this->hasMany('App\Review', 'order_id', 'id');
	}

	public function scopeNew($query) {
		return $query
			->where('state', Config::get('constants.ORD_NEW'))
			->orderBy('created_at', 'desc');
	}

	public function scopeAccepted($query) {
		return $query
			->where('state', Config::get('constants.ORD_ACCEPTED'))
			->orderBy('created_at', 'desc');
	}

	public function scopeProcessing($query) {
		return $query
			->where('state', Config::get('constants.ORD_PROCESSING'))
			->orderBy('created_at', 'desc');
	}
	
	public function scopeNonActive($query) {
		return $query
			->where('state', Config::get('constants.ORD_NEW'))
			->orderBy('created_at', 'desc');
	}
	
	public function scopeActive($query) {
		return $query
			->where('state', Config::get('constants.ORD_ACCEPTED'))
			->orWhere('state', Config::get('constants.ORD_PROCESSING'))
			->orderBy('created_at', 'desc');
	}
	
	public function scopeCurrent($query) {
		return $query
			->where('state', Config::get('constants.ORD_NEW'))
			->orWhere('state', Config::get('constants.ORD_ACCEPTED'))
			->orWhere('state', Config::get('constants.ORD_PROCESSING'))
			->orderBy('created_at', 'desc');
	}
	

	
	public function scopeHistory($query) {
		return $query
			->where('state', Config::get('constants.ORD_COMPLETE'))
			->orWhere('state', Config::get('constants.ORD_CANCEL'))
			->orderBy('created_at', 'desc');
	}
	
	public function scopeComplete($query) {
		return $query
			->where('state', Config::get('constants.ORD_COMPLETE'))
			->orderBy('created_at', 'desc');
	}
	
	public function scopeCancel($query) {
		return $query
			->where('state', Config::get('constants.ORD_CANCEL'))
			->orderBy('created_at', 'desc');
	}
	
	/*=== API ===*/
	public static function api_getOrder($id, $userId) {
		return Order::select('id', 'no', 'service_id', 'state', 'pro_id', 'address', 'address_2',
				'est_excute_at', 'total_price', 'location', 'requirements', 'created_at', 'updated_at')
			->with([
				'service' => function($query) {
					$query->select('id', 'name');
				},
				'pro'  => function($query) {
					$query->select('id', 'name', 'phone', 'avatar');
				},
				'pro.profile'  => function($query) {
					$query->select('id', 'date_of_birth', 'gender', 'location', 'rating');
				},
			])
			->where('id', $id)
			->where('user_id', $userId)
			->first();
	}
	
	public static function api_getActive($userId) {
		return Order::select('id', 'no', 'service_id', 'state', 'pro_id', 'est_excute_at', 'excuted_at')
			->with('service')
			->where('user_id', $userId)
			->active()
			->orderBy('est_excute_at', 'desc')
			->get();
	}
	
	public static function api_getNonActive($userId) {
		return Order::select('id', 'no', 'service_id', 'state', 'est_excute_at', 'created_at')
			->with('service', 'quotedPrice')
			->where('user_id', $userId)
			->nonActive()
			->orderBy('created_at', 'desc')
			->get();
	}
	
	public static function api_getHistory($userId) {
		return Order::select('id', 'no', 'service_id', 'state', 'updated_at')
			->with('service', 'review')
			->where('user_id', $userId)
			->history()
			->orderBy('updated_at', 'desc')
			->take(10)
			->get();
	}
}
