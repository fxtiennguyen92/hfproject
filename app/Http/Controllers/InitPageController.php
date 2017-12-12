<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\ServiceGroup;
use Illuminate\Support\Facades\Config;

class InitPageController extends Controller
{
	public function view() {
		$groups = ServiceGroup::all();
		
		return view(Config::get('constants.INIT_PAGE'), array(
			'groups' => $groups
		));
	}
	
	public function test() {
// 		$user = Auth::user();
		
// 		dd($user->email);
		
		return view('login', array(
		));
	}
}
