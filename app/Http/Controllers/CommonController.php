<?php

namespace App\Http\Controllers;

use App\Common;
use Illuminate\Http\Request;
use App\Company;

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

	public function getCompanies(Request $request) {
		$term = $request->get('term','');
		$comp = new Company();
		$companies = $comp->autocompleteByName($term);
		
		$results = array();
		foreach ($companies as $company) {
			$results[] = ['id' => $company->id,'value' => $company->name, 'address' => $company->address];
		}
		
		return response()->json($results, 200);
	}

	public function addCompany(Request $request) {
		$comp = new Company();
		$comp->name = $request->name;
		$comp->address = $request->address;
		
		$comp->save;
		return response()->json('', 200);
	}
}
