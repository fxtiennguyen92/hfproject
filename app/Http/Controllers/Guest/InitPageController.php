<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;

class InitPageController extends Controller
{
	public function view() {
		return view('guest.init', array());
	}
}
