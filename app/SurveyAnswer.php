<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyAnswer extends Model
{
	// table name
	protected $table = 'survey_answers';

	public function getById($id) {
		return $this
			->where('id', $id)
			->first();
	}

	public function scopeAvailable($query) {
		return $query->where('delete_flg', 0);
	}
}
