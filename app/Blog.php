<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Blog extends Model
{
	// table name
	protected $table = 'blogs';
	
	protected $fillable = [
		'id', 'title', 'url_name', 'category', 'image', 'content', 'video_flg', 'highlight_flg', 'updated_by', 'updated_at'
	];

	public function getByUrlName($urlName) {
		return $this
			->where('url_name', $urlName)
			->available()
			->first();
	}
	
	public function getNewestBlogs() {
		return $this->select('id', 'title', 'url_name', 'category', 'image')
			->available()
			->orderBy('created_at', 'desc')
			->take(3)
			->get();
	}
	
	public function getHighlightBlogs() {
		return $this->select('id', 'title', 'url_name', 'image')
			->available()
			->highlight()
			->orderBy('created_at', 'desc')
			->get();
	}
	
	public function getCategories() {
		return $this->select('category')
		->distinct()
		->orderBy('category')
		->get();
	}
	
	/** Management **/
	public function getById($id) {
		return $this
			->where('id', $id)
			->first();
	}
	
	public function getAllForMng() {
		return $this->get();
	}

	public static function updateHighlightFlg($id, $flg, $updatedBy) {
		return Blog::where('id', $id)
			->update([
						'highlight_flg' => $flg,
						'updated_by' => $updatedBy
			]);
	}

	public function scopeHighlight($query) {
		return $query->where('highlight_flg', Config::get('constants.FLG_ON'));
	}

	public function scopeAvailable($query) {
		return $query->where('delete_flg', Config::get('constants.FLG_OFF'));
	}
}
