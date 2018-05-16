<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
	// table name
	protected $table = 'events';

	/**
	 * get all events for view customer page
	 * 
	 * @return unknown
	 */
	public function getAll() {
		return $this
			->orderBy('date')
			->orderBy('from_time')
			->get();
	}
}
