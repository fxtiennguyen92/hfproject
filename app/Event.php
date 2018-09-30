<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
	// table name
	protected $table = 'events';

	/**
	 * get all events for view customer page
	 */
	public function getAll() {
		return $this
			->where('date', '>=', Carbon::today())
			->orderBy('date')
			->orderBy('from_time')
			->get();
	}
	
	public function getAllForMng() {
		return $this
			->orderBy('date')
			->orderBy('from_time')
			->get();
	}
}
