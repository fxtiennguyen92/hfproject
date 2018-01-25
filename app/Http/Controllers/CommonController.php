<?php

namespace App\Http\Controllers;

use App\Common;

class CommonController
{
	public static function convertStringToDate($string) {
		if ($string) {
			return \DateTime::createFromFormat('d/m/Y', $string);
		}
		
		return null;
	}
	
	public static function convertStringToDateTime($string) {
		if ($string) {
			return \DateTime::createFromFormat('d/m/Y H:i', $string);
		}
		
		return null;
	}
	
	public function getDistByCity($code) {
		$model = new Common();
		return $model->getDistList($code);
	}
}
