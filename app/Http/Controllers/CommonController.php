<?php

namespace App\Http\Controllers;

class CommonController
{
	public static function convertStringToDate($string) {
		if ($string) {
			return \DateTime::createFromFormat('d/m/Y', $string);
		}
		
		return null;
	}
}
