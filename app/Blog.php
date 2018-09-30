<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Blog extends Model
{
	// table name
	protected $table = 'blogs';
	
	protected $fillable = [
		'id', 'title', 'url_name', 'category', 'image', 'content', 'video_flg', 'highlight_flg',
		'updated_by', 'updated_at', 'published_at'
	];

	public function getByUrlName($urlName) {
		return $this
			->where('url_name', $urlName)
			->available()
			->first();
	}
	
	public function getNewestBlogs() {
		return $this->select('id', 'title', 'url_name', 'category', 'image')
			->blog()
			->available()
			->orderBy('created_at', 'desc')
			->take(3)
			->get();
	}
	
	public function getHighlightBlogs() {
		return $this->select('id', 'title', 'url_name', 'image')
			->blog()
			->available()
			->highlight()
			->orderBy('created_at', 'desc')
			->get();
	}
	
	public function getCategories() {
		return $this->select('category')
			->blog()
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
	
	public function getAllBlogsForMng() {
		return $this
			->blog()
			->get();
	}

	public function getAllVideosForMng() {
		return $this
			->video()
			->get();
		
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

	public function scopeBlog($query) {
		return $query->where('video_flg', Config::get('constants.FLG_OFF'));
	}

	public function scopeVideo($query) {
		return $query->where('video_flg', Config::get('constants.FLG_ON'));
	}

	public function scopeAvailable($query) {
		return $query->where('delete_flg', Config::get('constants.FLG_OFF'));
	}
	
	
	/*=== API ===*/
	
	public static function api_getCategoryList() {
		return Blog::select('category')
			->distinct()
			->get();
	}
	
	public static function api_get($url) {
// 		$blog = Blog::where('url_name', $url)
		return Blog::where('id', $url)
			->blog()
			->available()
			->first();
	}
	
	public static function api_getTop($page, $rowsPerPage) {
		$offset = ($page - 1) * $rowsPerPage;
		
		return Blog::select('id', 'title', 'url_name', 'image', 'category', 'published_at')
			->offset($offset)
			->limit($rowsPerPage)
			->blog()
			->available()
			->orderBy('published_at', 'desc')
			->get();
	}
}
