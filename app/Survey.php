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
		return $this
			->hasMany('App\SurveyAnswer', 'question_id')
			->select(['id', 'question_id', 'content', 'other_flg', 'previous_answer', 'order_dsp'])
			->available()
			->orderBy('order_dsp');
	}

	public function scopeAvailable($query) {
		return $query->where('delete_flg', 0);
	}
	
	
	/*=== API ===*/
	public static function api_getByService($serviceId) {
		return Survey::select(['id', 'content', 'answer_type'])
			->with('answers')
			->where('service_id', $serviceId)
			->available()
			->orderBy('order_dsp')
			->get();
	}
}
