<?php
namespace App\Http\Controllers\Mng;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\User;
use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;

class UserController extends Controller
{
	public function viewList(Request $request) {
		$userModel = new User();
		$users = $userModel->getAllUserForMng();
		
		// report
		$frm = '';
		$end = '';
		if ($request->fromDate) {
			$fromDate = CommonController::convertStringToDate($request->fromDate);
			$frm = date('Y-m-01 00:00:00', strtotime($fromDate->format('Y-m-d')));
		}
		
		$endDate = new \DateTime();
		if ($request->endDate) {
			$endDate = CommonController::convertStringToDate($request->endDate);
		}
		$end = date('Y-m-t 23:59:59', strtotime($endDate->format('Y-m-d')));
		$orderModel = new Order();
		$usingUserCountReport = $orderModel->reportUsingUserByMonth($frm, $end);
		
		return view(Config::get('constants.MNG_USER_LIST_PAGE'), array(
						'users' => $users,
						'usingUserCountReport' => $usingUserCountReport,
		));
	}
}
