<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
	// table name
	protected $table = 'survey_questions';

	public function getById($id) {
		return $this::with('answers')
			->where('id', $id)
			->first();
	}

	public function getByService($serviceId) {
		return $this::with('answers')
			->where('service_id', $serviceId)
			->available()
			->orderBy('order_dsp')
			->get();
	}

	public function answers() {
		return $this->hasMany('App\SurveyAnswer', 'question_id')->available();
	}

	public function scopeAvailable($query) {
		return $query->where('delete_flg', 0);
	}
}
