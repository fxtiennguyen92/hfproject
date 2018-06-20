<?php

namespace App\Http\Controllers;

use App\SAC;

class SACController extends Controller
{

	public static function getSAC($id) {
		$sac = substr(str_shuffle("0123456789"), 0, 4);
		return SAC::updateOrCreate(
			['id' => $id],
			['sac' => $sac]
		);
	}

	public static function checkSAC($id, $code) {
		$sac = SAC::find($id);
		if ($sac) {
			if ($sac->sac == $code) {
				return true;
			}
		}
		
		return false;
	}

	public static function deleteSAC($id) {
		SAC::destroy($id);
	}
}
