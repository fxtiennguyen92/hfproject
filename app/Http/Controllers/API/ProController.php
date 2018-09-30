<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;

class ProController extends Controller
{
	public function getBasicInfo($id) {
		try {
			$pro = User::api_getProBasicInfo($id);
			if ($pro) {
				return response()->json($pro, 200);
			}
			
			return response()->json('', 400);
		} catch (\Exception $e) {
			return response()->json($e->getMessage(), 500);
		}
	}
}
