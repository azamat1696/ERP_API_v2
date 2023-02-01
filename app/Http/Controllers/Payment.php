<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\transactionTest;
use App\Payments\CardPlusClass;
use Illuminate\Http\Request;

class Payment extends Controller
{
  public function store(Request $request) {
      
        $paymentTypes = $request->type;
     
       if ($paymentTypes == "cardpluss")  {
           // Card Plus ile ödeme alma
           $params = [
                'amount' => $request->TotalPrice,
               //'amount' => 1,
               'cardParams' =>  [
                   "pan" => $request->cardNumber,
                   "cv2" => $request->cardCvv,
                   "Ecom_Payment_Card_ExpDate_Month" => $request->cardMonth,
                   "Ecom_Payment_Card_ExpDate_Year" =>substr($request->cardYear,-2)
               ],
               'customer' => $this->customerFields($request->CustomerId)
           ];
           return response()->json($this->cardPluss($params));
       }
       // Diğer Ödeme Yöntemleri gelecek
      return response()->json($request->all());
  }
  
  
  public function cardPluss($detail) 
  {
      
     $transactionsParams = new CardPlusClass($detail['amount'],$detail['cardParams'],$detail['customer']);
      $save =  transactionTest::create([
 			'url' => '',
            'params' => json_encode($transactionsParams->staticParams['params']),
			'transactionNo' => $transactionsParams->staticParams['params']['oid']
        ]);
       return $save->id;
       
  }
  public function customerFields($customerId)
  {
      $customer = Customer::findOrFail($customerId);
      return [
          'email'  => $customer->Email,
          'name'  => $customer->Name,
          'surname'  => $customer->Surname,
      ];
  }
  public function checkTransaction($id) {
      $transaction = transactionTest::where('id','=',$id)->first();
      if ($transaction) {
          if ($transaction->status == 1)
          {
              return response()->json([
                  'process' => 'completed',
				  'TransactionNo' => $transaction->transactionNo
              ]);
              // eger ödeme başarılıysa burdan silinecektir
          }
          return response()->json([
              'process' => 'continue'
          ]);
      }
      return response()->json([
          'process' => 'deleted'
      ]);
  }
}
