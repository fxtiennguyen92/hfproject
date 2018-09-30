<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Request;
use App\WalletTransactionRequest;
use App\Wallet;

class WalletController extends Controller
{
	public function depositRequest(Request $request) {
		if (!auth()->check()) {
			throw new NotFoundHttpException();
		}
		
		$wallet = Wallet::find(auth()->user()->id);
		if (!$wallet) {
			return response()->json('', 409);
		}
		
		try {
			$walletTransRequest = new WalletTransactionRequest();
			$walletTransRequest->wallet_id = auth()->user()->id;
			$walletTransRequest->created_by = auth()->user()->id;
			$walletTransRequest->prev_wallet = $wallet->wallet_1;
			$walletTransRequest->wallet = $request->wallet;
			$walletTransRequest->save();
			
			$wallet->wallet_1 = $wallet->wallet_1 - $request->wallet;
			$wallet->save();
			
			return response()->json('', 200);
		} catch (\Exception $e) {
			return response()->json($e->getMessage(), 500);
		}
	}
}
