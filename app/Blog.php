<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Blog extends Model
{
	// table name
	protected $table = 'blogs';
	
	protected $fillable = [
					'id', 'title', 'url_name', 'style', 'image', 'content',
	];

	public function getByUrlName($urlName) {
		return $this->where('url_name', $urlName)->first();
	}
	
	public function getNewestBlogs() {
		return $this->select('id', 'title', 'url_name', 'style', 'image')
			->orderBy('created_at', 'desc')
			->take(5)
			->get();
	}
	
	public function getTopGeneralBlog() {
		return $this->select('id', 'title', 'url_name', 'style', 'image')
			->general()
			->orderBy('created_at', 'desc')
// 			->take(5)
			->get();
	}
	
	public function getTopProBlog() {
		return $this->select('id', 'title', 'url_name', 'style', 'image')
			->pro()
			->orderBy('created_at', 'desc')
// 			->take(5)
			->get();
	}
	
	public function getAll() {
		return $this->get();
	}

	public function scopeGeneral($query) {
		return $query->where('style', Config::get('constants.BLOG_GENERAL'));
	}

	public function scopePro($query) {
		return $query->where('style', Config::get('constants.BLOG_PRO'));
	}
}
