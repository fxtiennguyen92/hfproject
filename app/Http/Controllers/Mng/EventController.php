<?php
namespace App\Http\Controllers\Mng;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use App\Event;
use App\Http\Controllers\CommonController;

class EventController extends Controller
{
	public function viewList() {
		$eventModel = new Event();
		$events = $eventModel->getAllForMng();
		
		return view(Config::get('constants.MNG_EVENT_LIST_PAGE'), array(
						'events' => $events,
		));
	}

	public function create(Request $request) {
		try {
			$event = new Event();
			
			$event->name = $request->name;
			$event->from_time = $request->from_time;
			$event->end_time = $request->end_time;
			$event->date = CommonController::convertStringToDate($request->date);
			$event->place = $request->place;
			$event->address = $request->address;
			$event->save();
			
			return response()->json('', 200);
		} catch (\Exception $e) {
			return response()->json($e->getMessage(), 500);
		}
	}

	public function delete($id) {
		try {
			Event::destroy($id);
			return response()->json('', 200);
		} catch (\Exception $e) {
			return response()->json($e->getMessage(), 500);
		}
		
		return redirect()->route('mng_pa_list');
	}
}
