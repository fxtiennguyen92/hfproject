<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\ServiceGroup;

class InitPageController extends Controller
{
	public function view() {
		$groups = ServiceGroup::all();
		
		return view('template.index', array(
			'groups' => $groups
		));
// 		return view('guest.init', array());
	}
}
