<?php

namespace App\Http\Controllers\Mng;

use App\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CommonController
{
	protected function validator(array $data) {
		return Validator::make($data, [
						'code' => 'required|string|max:10|unique:commons',
						'value' => 'nullable|string|max:10',
						'name' => 'nullable|string|max:50',
						'name_2' => 'nullable|string|max:50',
						'text' => 'nullable|string',
						'order_dsp' => 'nullable|integer',
		]);
	}

	public function viewList($key = null) {
		if (!$key) {
			$key = Config::get('constants.COMMON_ROOT');
		}
		
		$commonModel = new Common();
		$commons = $commonModel->getAllByKey($key);
		
		if (sizeof($commons) == 0) {
			throw new NotFoundHttpException();
		}

		return view(Config::get('constants.MNG_COMMON_LIST_PAGE'), array(
						'key' => $key,
						'commons' => $commons,
		));
	}

	public function createCommon($key, Request $request) {
		$validator = $this->validator($request->all());
		if ($validator->fails()) {
			return response()->json($validator->errors()->first(), 409);
		}
		
		try {
			$common = new Common();
			$common->key = $key;
			$common->code = $request->code;
			$common->value = $request->value;
			$common->name = $request->name;
			$common->name_2 = $request->name_2;
			$common->text = $request->text;
			$common->order_dsp = $request->order_dsp;
			$common->updated_by = auth()->user()->id;
			
			$common->save();
			return response()->json('', 200);
		} catch (\Exception $e) {
			return response()->json($e->getMessage(), 400);
		}
	}

	public function delete($key, $code, Request $request) {
		try {
			Common::updateDeleteFlg($key, $code, Config::get('constants.FLG_ON'));
			return response()->json('', 200);
		} catch (\Exception $e) {
			return response()->json($e->getMessage(), 400);
		}
	}

	public function active($key, $code, Request $request) {
		try {
			Common::updateDeleteFlg($key, $code, Config::get('constants.FLG_OFF'));
			return response()->json('', 200);
		} catch (\Exception $e) {
			return response()->json($e->getMessage(), 400);
		}
	}
}
