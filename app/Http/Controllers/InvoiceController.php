<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceDetailToCustomer;
use App\Models\Invoice;
use App\Models\ReceiptCollection;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PDF;
class InvoiceController extends Controller
{
    public function index() {
        return response()->json(Invoice::orderBy('created_at','DESC')->get());
    }
    public function update(Request $request,$id)
    {
        $invoice = Invoice::findOrFail($id);
   
        $invoice->update([
           'InvoiceNo' => $request->InvoiceNo
        ]);
        
            // Receipt Guncelle
        $receipt = ReceiptCollection::where('invoice_id',$invoice->id)->first();
        
        $customer = Reservation::leftJoin('customers',function ($join) {
            $join->on('customers.id','=','reservations.customers_id');
        })->where('reservations.id','=',$invoice->reservation_id)->first();

        $receipt->update( [
            'MessageContent' => 
                'SAYIN '.$customer->Name." ".$customer->Surname. ' den/dan '.$invoice->InvoiceNo.";"."NO'LU ARAÇ KİRALAMA Bedeli karşılığında "
                .$this->moneyToSting($invoice->UnitTotal,'.',$customer->CurrencySymbol,$customer->CurrencyType).
                " Teşekkürlerle alınmıştır.",
        ]);
        $reservationParentId = DB::table('reservations')->where('id',$invoice->reservation_id)->first();
       if($reservationParentId->ParentReservationId !== null){
           $reservationParentId = DB::table('current_reservations_v')->where('id',$reservationParentId->ParentReservationId)->first();
           return response()->json($reservationParentId);
       }
       $reservationParentId = DB::table('current_reservations_v')->where('id',$invoice->reservation_id)->first();
      
        return response()->json($reservationParentId);
    }
    
    public function invoiceDownload($id)
    {
        $invoice = Invoice::findOrFail($id);
        
        $reservation = Reservation::leftJoin('customers',function ($join) {
            $join->on('reservations.customers_id','=','customers.id');
        })->where('reservations.id',$invoice->reservation_id)->first();
   
        $customer = $reservation->Name." ".$reservation->Surname;
        $personal = auth()->user()->name .' '.auth()->user()->surname;
        $pdf =  PDF::loadView('Corparate.Invoice',
            compact('invoice',
            'customer',
            'personal',
            'reservation'
            ))->setPaper('a4', 'portrait');
        $pdfName = rand(1111111,999999999).".pdf";
        return $pdf->download($pdfName);
 
    }
    
    public function sendMailToCustomer($id) {
        $invoice = Invoice::findOrFail($id);
        $customerDetail = Reservation::select('customers.Email','customers.Name','customers.Surname')->leftJoin('customers',function ($join){
           $join->on('reservations.customers_id','=','customers.id');
       })->where('reservations.id','=',$invoice->reservation_id)->first();
        if ($customerDetail->Email)
        {
         
            $customer = $customerDetail->Name." ".$customerDetail->Surname;
            // Mail Atma
            $personal = auth()->user()->name .' '.auth()->user()->surname;
            $pdf =  PDF::loadView('Corparate.Invoice',
                compact('invoice',
                    'customer',
                    'personal'
                ))->setPaper('a4', 'portrait');
            $pdfName = time().".pdf";
            $pdf->save(public_path('uploads/mail/'.$pdfName) );
            try 
            {
                Mail::to($customerDetail->Email)->send(new InvoiceDetailToCustomer($pdfName));
                unlink(public_path('uploads/mail/'.$pdfName));
                return response()->json(true,200);
            } catch (\Exception $exception)
            {
                return response()->json($exception->getMessage(),400);
            }
        }
    }
    
    public function moneyToSting($sayi, $separator, $currencySembol,$currencyType) :string {
        $sayarr = explode($separator,$sayi);
        $sentTitle = ($currencySembol != '₺') ? 'SENT' : 'KRŞ';
        $str = "";
        $items = array(
            array("", ""),
            array("BİR", "ON"),
            array("İKİ", "YİRMİ"),
            array("ÜÇ", "OTUZ"),
            array("DÖRT", "KIRK"),
            array("BEŞ", "ELLİ"),
            array("ALTI", "ALTMIŞ"),
            array("YEDİ", "YETMİŞ"),
            array("SEKİZ", "SEKSEN"),
            array("DOKUZ", "DOKSAN")
        );

        for ($eleman = 0; $eleman<count($sayarr); $eleman++) {

            for ($basamak = 1; $basamak <=strlen($sayarr[$eleman]); $basamak++) {
                $basamakd = 1 + (strlen($sayarr[$eleman]) - $basamak);


                try {
                    switch ($basamakd) {
                        case 6:
                            $str = $str . " " . $items[substr($sayarr[$eleman],$basamak - 1,1)][0] . " YÜZ";
                            break;
                        case 5:
                            $str = $str . " " . $items[substr($sayarr[$eleman],$basamak - 1,1)][1];
                            break;
                        case 4:
                            if ($items[substr($sayarr[$eleman],$basamak - 1,1)][0] != "BİR") $str = $str . " " . $items[substr($sayarr[$eleman],$basamak - 1,1)][0] . " BİN";
                            else $str = $str . " BİN";
                            break;
                        case 3:
                            if($items[substr($sayarr[$eleman],$basamak - 1,1)][0]=="") {
                                $str.=" ";
                            }
                            elseif ($items[substr($sayarr[$eleman],$basamak - 1,1)][0] != "BİR" ) $str = $str . " " . $items[substr($sayarr[$eleman],$basamak - 1,1)][0] . " YÜZ";

                            else $str = $str . " YÜZ";
                            break;
                        case 2:
                            $str = $str . " " . $items[substr($sayarr[$eleman],$basamak - 1,1)][1];
                            break;
                        default:
                            $str = $str . " " . $items[substr($sayarr[$eleman],$basamak - 1,1)][0];
                            break;
                    }
                } catch (Exception $err) {
                    echo $err->getMessage();
                    break;
                }
            }
            if ($eleman< 1) $str = $str . " ".$currencyType ." (".$currencySembol.")";
            else {
                if ($sayarr[1] != "00") $str = $str . "  ".$sentTitle;
            }
        }
        return $str;
    }
    public function invoiceReport(Request $request){
        $commonQueryPrefix = '';
        if ($request->filled('startDateTime'))
        {

            $commonQueryPrefix .= " AND StartDateTime >= '{$request->startDateTime} 00:00' ";
        }
        
        if ($request->filled('endDateTime'))
        {

            $commonQueryPrefix .= " AND EndDateTime <= '{$request->endDateTime} 23:59' ";
        }
        
        if ($request->filled('ReservationNo'))
        {

            $commonQueryPrefix .= " AND ReservationNo = '{$request->ReservationNo}' ";
        }
        
        if ($request->filled('InvoiceNo'))
        {

            $commonQueryPrefix .= " AND InvoiceNo = '{$request->InvoiceNo}' ";
        }
        
        $commonWhere = !empty($commonQueryPrefix) ? " where ".substr($commonQueryPrefix,4) : '';

        $rowQuery= '
         SELECT
       i.id as id,
       i.reservation_id as reservation_id,
       i.InvoiceNo as InvoiceNo,
       i.UnitPrice as UnitPrice,
       i.Piece as Pieces,
       i.VatRate as VatRate,
       i.UnitTotal as UnitTotal,
       i.SubTotal as Subtotal,
       i.VatTotal as VatTotal,
       i.Total as Total,
       i.TotalSting as TotalSting,
       i.created_at as created_at,
       rc.ReceiptCollectionNo as ReceiptCollectionNo,
       r.ReservationNo as ReservationNo,
       IF(r.ParentReservationId = NULL,"",( SELECT ReservationNo from reservations where id = r.ParentReservationId)) as ParentReservationNo,
       (
         select CONCAT(Name," ",Surname)
           from customers
           where customers.id = r.customers_id
       ) as customer,
       r.customers_id as customers_id,
       r.ReservationStatus as ReservationStatus,
       r.PaymentMethod as PaymentMethod,
       r.PaymentState as  PaymentState,
       r.StartDateTime as StartDateTime,
       r.EndDateTime as EndDateTime,
       r.CurrencySymbol as CurrencySymbol,
       rc.id  as ReceiptID
FROM invoices i
 left join receipt_collections rc on i.id = rc.invoice_id
 left join reservations r on r.id = i.reservation_id  '.$commonWhere;
        $result = DB::select($rowQuery);
        return response()->json($result);
    }
    public function updateInvoiceUpdate(Request $request){
        $invoice = Invoice::findOrFail($request->id);
        $invoice->update([
            'InvoiceNo' => $request->InvoiceNo
        ]);

        // Receipt Guncelle
        $receipt = ReceiptCollection::where('invoice_id',$invoice->id)->first();

        $customer = Reservation::leftJoin('customers',function ($join) {
            $join->on('customers.id','=','reservations.customers_id');
        })->where('reservations.id','=',$invoice->reservation_id)->first();

        $receipt->update( [
            'MessageContent' =>
                'SAYIN '.$customer->Name." ".$customer->Surname. ' den/dan '.$invoice->InvoiceNo.";"."NO'LU ARAÇ KİRALAMA Bedeli karşılığında "
                .$this->moneyToSting($invoice->UnitTotal,'.',$customer->CurrencySymbol,$customer->CurrencyType).
                " Teşekkürlerle alınmıştır.",
        ]);
        return response()->json([
            'id' => $invoice->id,
            'InvoiceNo' => $invoice->InvoiceNo
        ]);
    }
}
