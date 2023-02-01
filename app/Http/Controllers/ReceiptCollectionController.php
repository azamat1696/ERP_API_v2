<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceDetailToCustomer;
use App\Mail\ReceiptDetailToCustomer;
use App\Models\Invoice;
use App\Models\ReceiptCollection;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PDF;
class ReceiptCollectionController extends Controller
{
    public function update(Request $request,$id)
    {
 
        $receipt = ReceiptCollection::findOrFail($id);
        $receipt->update([
            'ReceiptCollectionNo' => $request->ReceiptCollectionNo
        ]);
        
              $reservationParentId = DB::table('reservations')->where('id',$receipt->reservation_id)->first();
        if($reservationParentId->ParentReservationId !== null){
            $reservationParentId = DB::table('current_reservations_v')->where('id',$reservationParentId->ParentReservationId)->first();
            return response()->json($reservationParentId);
        }
        $reservationParentId = DB::table('current_reservations_v')->where('id',$receipt->reservation_id)->first();

        return response()->json($reservationParentId);
    }

    public function receiptDownload($id) {
        $receipt = ReceiptCollection::findOrFail($id);
        $invoice = Invoice::findOrFail($receipt->invoice_id);
        $reservation = Reservation::findOrFail($receipt->reservation_id);
        $pdf =  PDF::loadView('Corparate.Receipt',
            compact('receipt',
                  'invoice',
                            'reservation'
            ))->setPaper('a4', 'portrait');
        $pdfName = rand(1111111,999999999).".pdf";
        return $pdf->download($pdfName);

    }

    public function sendMailToCustomer($id) {
        
        $receipt = ReceiptCollection::findOrFail($id);
        $invoice = Invoice::findOrFail($receipt->invoice_id);
        $reservation = Reservation::findOrFail($receipt->reservation_id);
        $customerDetail = Reservation::select('customers.Email','customers.Name','customers.Surname')->leftJoin('customers',function ($join){
            $join->on('reservations.customers_id','=','customers.id');
        })->where('reservations.id','=',$receipt->reservation_id)->first();
        if ($customerDetail->Email)
        {
 
            $pdf =  PDF::loadView('Corparate.Receipt',
                compact(  'receipt',
                         'invoice',
                                   'reservation'
                
                ))->setPaper('a4', 'portrait');
            $pdfName = time().".pdf";
            $pdf->save(public_path('uploads/mail/'.$pdfName) );
            try
            {
                Mail::to($customerDetail->Email)->send(new ReceiptDetailToCustomer($pdfName));
                unlink(public_path('uploads/mail/'.$pdfName));
                return response()->json(true,200);
            } catch (\Exception $exception)
            {
                return response()->json($exception->getMessage(),400);
            }
        }
    }
    public function updateReceiptUpdate(Request $request){
        $receipt = ReceiptCollection::findOrFail($request->id);
        $receipt->update([
            'ReceiptCollectionNo' => $request->ReceiptCollectionNo
        ]);
        return response()->json([
            'id' => $receipt->id,
            'ReceiptCollectionNo' => $receipt->ReceiptCollectionNo
        ]);
    }
}
