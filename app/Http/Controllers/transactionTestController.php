<?php

namespace App\Http\Controllers;

use App\Models\transactionTest;
use Illuminate\Http\Request;

class transactionTestController extends Controller
{
    
    public  function test($id) {
        $transactions = transactionTest::find($id);
        return view('PaymentState.Transaction',compact('transactions'));
    }
	
    public function success(Request $request) {
		$success =   $request->all();
        return view('PaymentState.Success',compact('success'));
    }
	
    public function fail(Request $request) {
		$errors =   $request->all();
        return view('PaymentState.Fail',compact('errors'));
    }
	
	public function payFailed($orderNo) {
	  $transactions = transactionTest::where('transactionNo','=',$orderNo)->firstOrFail();
	  $transactions->delete();
		
	}
	
	public function paySuccess($orderNo) {
	  $transactions = transactionTest::where('transactionNo','=',$orderNo)->first();
	  $transactions->update([
	  'params' => '',
      'status' => 1,
	  ]);
		
	}
}
