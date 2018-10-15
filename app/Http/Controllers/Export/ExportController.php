<?php

namespace App\Http\Controllers\Export;

use App\Http\Controllers\Controller;
use App\User;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
	protected $data;
	
	public function proExport() {
		$model = new User();
		$this->data = $model->getAllProForMng();
		
		return Excel::create('pros-'.date('ymdhis'), function($excel) {
			$excel->sheet('data', function($sheet) {
				$sheet->row(1, array(
								'Id',
								'Họ tên',
								'Số điện thoại',
								'Email',
								'Ngày tháng năm sinh',
								'Giới tính',
								'CMND',
								'Ngày cấp',
								'Nơi cấp',
								'Chỗ ở hiện nay',
				));
				
				foreach($this->data as $key => $a) {
					$sheet->row($key+2, array(
									$a->id,
									$a->name,
									$a->phone,
									$a->email,
									date_format(date_create($a->profile->date_of_birth), 'd/m/Y'),
									($a->gender == '1' ? 'Nam' : 'Nữ'),
									json_decode($a->profile->gov_id)->id,
									json_decode($a->profile->gov_id)->date,
									json_decode($a->profile->gov_id)->place,
									$a->profile->address_1.
										(($a->profile->address_2) ? ' '.$a->profile->address_2 : '').
										(($a->profile->district_info) ? ', '.$a->profile->district_info->name : '').
										(($a->profile->city_info) ? ', '.$a->profile->city_info->name : ''),
					));
				}
			});
		})->download('xls');
	}
}
