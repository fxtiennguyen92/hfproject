<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\ServiceGroup;

class InitPageController extends Controller
{
	public function view() {
		$groups = ServiceGroup::all();
		
		return view(Config::get('constants.INIT_PAGE'), array(
			'groups' => $groups
		));
	}
}
