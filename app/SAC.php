<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SAC extends Model
{
	// table name
	protected $table = 'sac_temp';
	
	protected $fillable = ['id', 'sac', 'created_at', 'updated_at'];
}
