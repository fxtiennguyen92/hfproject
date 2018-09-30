<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\SAC;
use Illuminate\Http\Request;
use App\Http\Controllers\SMSController;

class SACController extends Controller
{
	public function getByPhone(Request $request) {
		$sac = substr(str_shuffle('0123456789'), 0, 4);
		
		try {
			SAC::updateOrCreate(
				['id' => $request->phone],
				['sac' => $sac]
			);
			
			//if (SMSController::sendPINCodeSMS($request->phone, $sac)) {
				return response()->json('', 200);
			//} else {
			//	return response()->json('Send failed', 422);
			//}
		} catch (\Exception $e) {
			return response()->json($e->getMessage(), 500);
		}
	}
	
	public function verify(Request $request) {
		$sac = SAC::find($request->phone);
		
		if (!$sac) {
			return response()->json('No code', 422);
		}
		if ($sac->sac !== $request->sac) {
			return response()->json('Invalid', 422);
		}
		
		return response()->json('', 200);
	}
}
