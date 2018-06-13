<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doc extends Model
{
	// table name
	protected $table = 'docs';
	
	protected $fillable = [
					'id', 'url_name', 'title', 'content'
	];

	public function getByUrlName($urlName) {
		return $this
			->where('url_name', $urlName)
			->first();
	}
	
	public function getById($id) {
		return $this
			->where('id', $id)
			->first();
	}
	
	public function getAllForMng() {
		return $this->get();
	}
}
