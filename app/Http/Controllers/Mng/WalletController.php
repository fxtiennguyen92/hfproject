<?php

namespace App\Http\Controllers\Mng;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Wallet;
use App\WalletTransaction;
use Illuminate\Support\Facades\Config;
use App\WalletTransactionRequest;

class WalletController extends Controller
{
	protected function validator(array $data) {
		return Validator::make($data, [
						'wallet' => 'required|integer',
		]);
	}

	public function viewTransactionList() {
		$model = new WalletTransaction();
		$transaction = $model->getListForMng();
		
		return view(Config::get('constants.MNG_WALLET_TRANS_PAGE'), array(
						'trans' => $transaction,
		));
	}

	public function update($id, Request $request) {
		$validator = $this->validator($request->all());
		if ($validator->fails()) {
			return response()->json($validator->errors()->first(), 409);
		}
		
		$wallet = Wallet::find($id);
		if (!$wallet) {
			return response()->json('', 400);
		}
		
		try {
			DB::beginTransaction();
			
			$transaction = new WalletTransaction();
			$transaction->wallet_id = $wallet->id;
			$transaction->prev_wallet = $wallet->wallet_1;
			$transaction->wallet = $request->wallet;
			$transaction->description = $request->description;
			$transaction->created_by = auth()->user()->id;
			$transaction->save();
			
			$wallet->wallet_1 = $wallet->wallet_1 + $request->wallet;
			$wallet->save();
			
			DB::commit();
			return response()->json('', 200);
		} catch (\Exception $e) {
			DB::rollback();
			return response()->json($e->getMessage(), 500);
		}
	}

	public function deposit($id, Request $request) {
		$validator = $this->validator($request->all());
		if ($validator->fails()) {
			return response()->json($validator->errors()->first(), 409);
		}
		
		$wallet = Wallet::find($id);
		if (!$wallet) {
			return response()->json('', 400);
		}
		
		if ($wallet->wallet_1 < $request->wallet) {
			return response()->json('', 409);
		}
		
		try {
			DB::beginTransaction();
			
			$transaction = new WalletTransaction();
			$transaction->wallet_id = $wallet->id;
			$transaction->prev_wallet = $wallet->wallet_1;
			$transaction->wallet = $request->wallet;
			$transaction->description = $request->description;
			$transaction->out_flg = Config::get('constants.FLG_ON');
			$transaction->created_by = auth()->user()->id;
			$transaction->save();
			
			$wallet->wallet_1 = $wallet->wallet_1 - $request->wallet;
			$wallet->save();
			
			DB::commit();
			return response()->json('', 200);
		} catch (\Exception $e) {
			DB::rollback();
			return response()->json($e->getMessage(), 500);
		}
	}
	
	public function viewRequestList() {
		$walletRequests = WalletTransactionRequest::getListForMng();
		
		return view(Config::get('constants.MNG_WALLET_TRANS_REQUEST_PAGE'), array(
						'walletRequests' => $walletRequests,
		));
	}
	
	public function requestDeposit($id, Request $request) {
		$walletRequest = WalletTransactionRequest::find($id);
		if (!$walletRequest) {
			return response()->json('', 400);
		}
		
		try {
			DB::beginTransaction();
			
			$transaction = new WalletTransaction();
			$transaction->wallet_id = $walletRequest->wallet_id;
			$transaction->prev_wallet = $walletRequest->prev_wallet;
			$transaction->wallet = $walletRequest->wallet;
			$transaction->description = $request->description;
			$transaction->out_flg = Config::get('constants.FLG_ON');
			$transaction->created_by = auth()->user()->id;
			$transaction->save();
			
			$walletRequest->excute_flg = Config::get('constants.FLG_ON');
			$walletRequest->updated_by = auth()->user()->id;
			$walletRequest->save();
			
			DB::commit();
			return response()->json('', 200);
		} catch (\Exception $e) {
			DB::rollback();
			return response()->json($e->getMessage(), 500);
		}
	}
	
	public function rejectDeposit($id, Request $request) {
		$walletRequest = WalletTransactionRequest::find($id);
		if (!$walletRequest) {
			return response()->json('', 400);
		}
		
		try {
			DB::beginTransaction();
			
			$walletRequest->description = $request->description;
			$walletRequest->excute_flg = Config::get('constants.FLG_REJECT');
			$walletRequest->updated_by = auth()->user()->id;
			$walletRequest->save();
			
			$wallet = Wallet::find($walletRequest->wallet_id);
			$wallet->wallet_1 = $wallet->wallet_1 + $walletRequest->wallet;
			$wallet->save();
			
			DB::commit();
			return response()->json('', 200);
		} catch (\Exception $e) {
			DB::rollback();
			return response()->json($e->getMessage(), 500);
		}
	}
}
