<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Service extends Model
{
	// table name
	protected $table = 'services';

	public function getByIdOrUrlName($string) {
		return $this->where('id', $string)
			->orWhere('url_name', $string)
			->serving()
			->available()
			->first();
	}
	
	public function getMostPopular() {
		return $this
			->child()
			->serving()
			->popular()
			->available()
			->orderBy('order_dsp')
			->orderBy('name')
			->get();
	}
	
	public function getHints() {
		return $this->select('hint') 
			->child()
			->serving()
			->available()
			->orderBy('hint')
			->distinct()
			->get();
	}
	
	public function getByHint($str) {
		return $this
			->where('hint', 'LIKE', '%'.$str.'%')
			->child()
			->serving()
			->available()
			->take(12)
			->orderBy('name')
			->get();
	}
	
	public function getServingChildrenByRoot($rootId) {
		return $this
			->where('parent_id', $rootId)
			->child()
			->serving()
			->available()
			->orderBy('order_dsp')
			->orderBy('name')
			->get();
	}
	
	public function getAllServingRoots() {
		return $this::with('children')
			->root()
			->serving()
			->available()
			->orderBy('order_dsp')
			->orderBy('name')
			->get();
	}
	
	public function getAllServingChildren() {
		return $this
			->child()
			->serving()
			->available()
			->orderBy('order_dsp')
			->orderBy('name')
			->get();
	}
	
	public function getByIdForMng($id) {
		return $this->where('id', $id)
			->first();
	}
	
	public function getAllRootsForMng() {
		return $this::with('children')
			->root()
			->orderBy('name')
			->get();
	}

	public static function updateDeleteFlg($id, $flg, $updatedBy) {
		return Service::where('id', $id)
			->update([
				'delete_flg' => $flg,
				'updated_by' => $updatedBy
			]);
	}

	public static function updateDeleteFlgByParentId($parentId, $flg, $updatedBy) {
		return Service::where('parent_id', $parentId)
			->update([
				'delete_flg' => $flg,
				'updated_by' => $updatedBy
			]);
	}

	public static function updateServeFlg($id, $flg, $updatedBy) {
		return Service::where('id', $id)
			->update([
				'serve_flg' => $flg,
				'updated_by' => $updatedBy
			]);
	}

	public static function updateServeFlgByParentId($parentId, $flg, $updatedBy) {
		return Service::where('parent_id', $parentId)
			->update([
				'serve_flg' => $flg,
				'updated_by' => $updatedBy
			]);
	}

	public static function updatePopularFlg($id, $flg, $updatedBy) {
		return Service::where('id', $id)
			->update([
				'popular_flg' => $flg,
				'updated_by' => $updatedBy
			]);
	}

	public function children() {
		return $this->hasMany('App\Service', 'parent_id', 'id')->orderBy('name');
	}

	public function scopeRoot($query) {
		return $query->where('parent_id', Config::get('constants.SERVICE_ROOT'));
	}

	public function scopeChild($query) {
		return $query->where('parent_id', '!=', Config::get('constants.SERVICE_ROOT'));
	}

	public function scopePopular($query) {
		return $query->where('popular_flg', Config::get('constants.FLG_ON'));
	}

	public function scopeServing($query) {
		return $query->where('serve_flg', Config::get('constants.FLG_ON'));
	}

	public function scopeAvailable($query) {
		return $query->where('delete_flg', Config::get('constants.FLG_OFF'));
	}
}
