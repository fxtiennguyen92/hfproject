<?php
namespace App\Http\Controllers\Mng;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use App\User;
use App\ProProfile;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\MailController;
use App\Common;
use App\Service;
use App\Http\Controllers\FileController;
use App\Company;
use Illuminate\Support\Facades\Validator;
use App\Event;
use App\EventUser;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\CommonController;
use App\Order;
use App\Http\Controllers\SMSController;
use App\TempPro;
use Spipu\Html2Pdf\Html2Pdf;

class ProController extends Controller
{
	protected function validator(array $data) {
		return Validator::make($data, [
						'name' => 'string|max:225',
						'email' => 'nullable|string|max:100|email',
						'phone' => 'string|max:25',
		]);
	}

	public function viewList(Request $request) {
		$userModel = new User();
		$pros = $userModel->getAllProForMng();
		
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
		$workProCountReport = $orderModel->reportWorkProByMonth($frm, $end);
		
		return view(Config::get('constants.MNG_PRO_LIST_PAGE'), array(
						'pros' => $pros,
						'workProCountReport' => $workProCountReport,
		));
	}

	public function edit($id) {
		$commonModel = new Common();
		$serviceModel = new Service();
		$eventModel = new Event();
		$eventUserModel = new EventUser();
		$companyModel = new Company();
		$userModel = new User();
		
		$pro = $userModel->getProOrProManager($id);
		
		if (!$pro) {
			throw new NotFoundHttpException();
		}
		
		$cities = $commonModel->getCityList();
		$districts = $commonModel->getDistList($pro->city);
		$services = $serviceModel->getAllServingRoots();
		$events = $eventModel->getAll();
		$companies = $companyModel->getAll();
		
		return view(Config::get('constants.MNG_PRO_PAGE'), array(
						'pro' => $pro,
						'cities' => $cities,
						'districts' => $districts,
						'services' => $services,
						'companies' => $companies
		));
	}

	public function update($id, Request $request, $returnFlg = true) {
		$validator = $this->validator($request->all());
		if ($validator->fails()) {
			return Redirect::back()->withInput()->with('error', 400);
		}
		
		// save image
		if ($request->avatar) {
			$image = $request->avatar;
			$baseToPhp = explode(',', $image); // remove the "data:image/png;base64,"
			if (sizeof($baseToPhp) == 2) {
				$data = base64_decode($baseToPhp[1]);
				FileController::saveAvatar($data, $id);
			}
		}
		if ($request->govEvidence) {
			$image = $request->govEvidence;
			$baseToPhp = explode(',', $image); // remove the "data:image/png;base64,"
			if (sizeof($baseToPhp) == 2) {
				$data = base64_decode($baseToPhp[1]);
				FileController::saveGovEnvidence($data, $id);
			}
		}
		
		try {
			DB::beginTransaction();
			
			$user = User::find($id);
			$pro = ProProfile::find($id);
			
			// account
			$user->name = $request->name;
			$user->email = $request->email;
			$user->phone = $request->phone;
			
			$user->save();
			
			// profile
			$pro->date_of_birth = CommonController::convertStringToDate($request->dateOfBirth);
			$pro->gender = $request->gender;
			$govId = array(
							'id' => $request->govId,
							'date' => $request->govDate,
							'place' => $request->govPlace
			);
			$pro->gov_id = json_encode($govId);
			$pro->fg_address = $request->familyRegAddress;
			$pro->fg_district = $request->familyRegDist;
			$pro->fg_city = $request->familyRegCity;
			$pro->address_1 = $request->address_1;
			$pro->address_2 = $request->address_2;
			$pro->district = $request->dist;
			$pro->city = $request->city;
			$pro->location = $request->location;
			$pro->company_id = $request->company;
			$pro->services = ($request->services) ? json_encode($request->services) : '[]';
			$pro->service_str = $request->service_str;
			$pro->training = $request->event;
			
			$pro->save();
			
			DB::commit();
			
			if ($returnFlg) {
				return redirect()->route('mng_pro_list');
			}
		} catch(\Exception $e) {
			DB::rollBack();
			return Redirect::back()->withInput()->with('error', $e->getMessage());
		}
	}

	public function active($id, Request $request) {
		$this->update($id, $request, false);
		
		$userModel = new User();
		$profileModel = new ProProfile();
		
		try {
			DB::beginTransaction();
			
			$userModel->activeProAccount($id);
			$profileModel->updateState($id, Config::get('constants.STS_READY'));
			
			DB::commit();
			
			// send message and email
			$this->sendMessageAndEmail($id);
			
			return redirect()->route('mng_pro_list');
		} catch (\Exception $e) {
			DB::rollback();
			return Redirect::back()->withInput()->with('error', $e->getMessage());
		}
	}

	public function delete($id) {
		try {
			DB::beginTransaction();
			
			$user = User::find($id);
			$user->delete();
			
			$pro = ProProfile::find($id);
			$pro->delete();
			
			DB::commit();
		} catch (\Exception $e) {
			DB::rollback();
		}
		
		return redirect()->route('mng_pro_list');
	}

	public function printTemp($id) {
		$userModel = new User();
		$pro = $userModel->getProOrProManager($id);
		if (!$pro) {
			throw new NotFoundHttpException();
		}
		
		$content = '<page style="font-family: freeserif">';
		$content.= '<h4>Thông tin Tài khoản</h4>';
		$content.= '<p>Họ và tên: <strong>'.$pro->name.'</strong></p>';
		$content.= '<p>Số Điện thoại: <strong>'.$pro->phone.'</strong></p>';
		$content.= '<p>MK Mặc định: <strong>'.(($pro->password_temp) ? $pro->password_temp : 'Đã thay đổi').'</strong></p>';
		$content.= '</page>';
		
		$html2pdf = new Html2Pdf('P', 'A4', 'fr');
		$html2pdf->pdf->SetDisplayMode('real');
		$html2pdf->writeHTML($content);
		$html2pdf->output();
	}

	/** Partner Acquisition **/
	public function viewListForPA() {
		$tempProModel = new TempPro();
		$compModel = new Company();
		$eventModel = new Event();
		
		$pros = $tempProModel->getAllForPA(auth()->user()->id);
		$companies = $compModel->getAll();
		$events = $eventModel->getAll();
		
		return view(Config::get('constants.PA_PRO_LIST_PAGE'), array(
						'pros' => $pros,
						'companies' => $companies,
						'events' => $events
		));
	}
	
	public function createForPA(Request $request) {
		$validator = $this->validator($request->all());
		if ($validator->fails()) {
			return response()->json($validator->errors()->first(), 409);
		}
		
		$userModel = new User();
		if ($userModel->existPhone($request->phone)) {
			return response()->json('Phone is registered', 409);
		}
		
		if (TempPro::existPhone($request->phone)) {
			return response()->json('Phone is registered', 409);
		}
		
		DB::beginTransaction();
		try {
			// create temp pro
			$temp = new TempPro();
			$temp->name = $request->name;
			$temp->phone = $request->phone;
			$temp->created_by = auth()->user()->id;
			$temp->save();
			
			// create event
			if ($request->event) {
				$this->createEventUser($temp->id, $request->event);
			}
			
			DB::commit();
			return response()->json('', 200);
		} catch (\Exception $e) {
			DB::rollback();
			return response()->json($e->getMessage(), 500);
		}
	}
	
	public function deleteForPA($id) {
		TempPro::destroy($id);
		
		return redirect()->route('pa_pro_list');
	}
	
	private function createEventUser($userId, $eventId) {
		$eventUser = new EventUser();
		$eventUser->id = $eventId;
		$eventUser->user_id = $userId;
		$eventUser->created_by = $userId;
		$eventUser->created_by = (auth()->check()) ? auth()->user()->id : null;
		
		$eventUser->save();
	}
	
	private function sendMessageAndEmail($id) {
		$userModel = new User();
		$pro = $userModel->getProOrProManager($id);
		SMSController::sendActiveProAccountSMS($pro->phone, $pro->password_temp);
		if ($pro->email) {
			MailController::sendActiveProAccountMail($pro->name, $pro->email, $pro->password_temp);
		}
	}
}
