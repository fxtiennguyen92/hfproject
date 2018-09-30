<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
	public function sendNewOrderNotification() { 
		return $this->sendNotification('ExponentPushToken[UHjMyXK21VHuep1x7_RahZ]');
	}
	
	private function sendNotification($endPoint) {
		try {
			$data = array(
				'to' => $endPoint,
				'title' => 'Test Send From Laravel',
				'body' => 'Send from Laravel'
			);
			$data_string = json_encode($data);
			
			$ch = curl_init(env('NOTIFICATION_EXPO_HOST'));
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'Content-Type: application/json',
					'Content-Length: ' . strlen($data_string))
			);
			
			$result = curl_exec($ch);
			curl_close($ch);
			
			return response()->json($result, 200);
		} catch(\Exception $e) {
			return response()->json($e->getMessage(), 500);
		}
	}
}
