<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventUser extends Model
{
	// table name
	protected $table = 'event_users';
	
	public function getByUserId($userId) {
		return $this
			->where('user_id', $userId)
			->get();
	}
	
	public function getByEventIdAndUserId($eventId, $userId) {
		return $this
			->where('id', $eventId)
			->where('user_id', $userId)
			->first();
	}
}
