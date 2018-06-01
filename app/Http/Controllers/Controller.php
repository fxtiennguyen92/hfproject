<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Service;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	public function getServiceHint() {
		if (!Session::has('hint-service')) {
			$serviceModel = new Service();
			$hints = $serviceModel->getHints();
			
			Session::put('hint-service', $hints);
		}
	}
}
