<?php

namespace App\Http\Controllers\Reservation;

use App\Exports\Export\ReservationsExport;
use App\Exports\Export\AllReservationsExport;
use App\Http\Requests\Reservation\ReservationSoreRequest;
use App\Http\Requests\Reservation\ReservationRenewPaymentRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\Reservation\ReservationUpdateRequest;
use App\Http\Requests\Reservation\ReservationAllUpdatesRequest;
use App\Models\Cars;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\ReceiptCollection;
use App\Models\Reservation;
use App\Models\ReservationDriver;
use App\Models\ReservationSignature;
 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class ReservationController extends Controller
{
    //
    public function store(ReservationSoreRequest $request) {
        
         
        /********************* STEPS **********************
         * 1. Create Reservations
         * 2. Create Customer Drivers
         * 3. Create Customer Signature
         */

        $reservation = 
            Reservation::create(
                $request->validated() + 
                [ 'ReservationNo' => $this->reservationNo() ] 
            );

        $invoice = $this->invoice(
            $reservation->id,
            $request->validated()['cars_id'],
            $request->validated()['TotalPrice'],
            $request->validated()['CurrencySymbol'],
            $request->validated()['CurrencyType']
        );
 
       $invoicePrint =  Invoice::create($invoice);
       
       $receipt = $this->receipt(
           $invoicePrint->id,
           $invoicePrint->InvoiceNo,
           $reservation->id,
           $invoicePrint->UnitTotal,
           $reservation->customers_id,
           $request->validated()['CurrencySymbol'],
           $request->validated()['CurrencyType']
       );
         ReceiptCollection::create($receipt);
         
        if ($request->has('reservation_drivers'))  {
            $drivers = [];
            foreach (json_decode($request->reservation_drivers) as $driver)   {
                $drivers[] = [
                    'reservation_id' => $reservation->id,
                    'driver_id' => $driver,
                ];
            }
            ReservationDriver::insert($drivers);
        }
        
        if ($request->has('CustomerSignature')) {
            $personel = '';
            if (Auth::user()) {
                $personel = Auth::user()->name . ' ' . Auth::user()->surname;
            }
            ReservationSignature::create([
                'reservation_id' =>$reservation->id,
                'user_id' => $personel ? auth()->id() : null,
                'CustomerSignature' => $request->CustomerSignature,
                'PersonalSignature' =>$personel,
            ]);
        }
        
        // disabled cars IsReserved when is payed
        // if ($request->validated()['PaymentState'] === 'Payed')
        // {
        //     $cars = Cars::find($request->validated()['cars_id']);
        //     $cars->update([
        //         'IsReserved' => true,
        //         'offices_id' => $request->validated()['drop_office_id']
        //     ]);
        // }
             $cars = Cars::find($request->validated()['cars_id']);
            $cars->update([
                'IsReserved' => true,
                'offices_id' => $request->validated()['drop_office_id']
            ]);
       
        return response()->json($request->validated());
    }
    
    public  function currentReservations() {
        //->where('ReservationStatus','=','Continues')
        return response()->json(DB::table('current_reservations_v')->get(),200);
    }
    
    public  function oldReservations() {
       
        return response()->json(DB::table('old_reservations')->get(),200);
    }
    
    public function exportAllReservations(){
        return Excel::download(new AllReservationsExport, 'rezervasyonlar.xlsx');
    }
    
    public function exportCurrentReservation() {
        return Excel::download(new ReservationsExport,'guncel-reservations.xlsx');
    }
    
    public function update(ReservationUpdateRequest $request,$id) {
        $childReservations = Reservation::where('ParentReservationId',$id)->get();
        
        $reservation = Reservation::findOrFail($id);
        $reservation->update([
            'ReservationStatus' => $request->validated()['ReservationStatus'],
            'PaymentState' => $request->validated()['PaymentState'],
        ]);
        
      foreach ($childReservations as $childReservation){
        Reservation::where('id',$childReservation->id)->update([
            'ReservationStatus' => $request->validated()['ReservationStatus'],
            'PaymentState' => $request->validated()['PaymentState']
        ]);
    }
        
        $cars = Cars::find($reservation->cars_id);
        
        if ($request->validated()['PaymentState'] === 'Payed')
        {
            $cars->update([
                'IsReserved' => true
            ]);
        }
        
        if ($request->validated()['ReservationStatus'] == 'Completed' || $request->validated()['ReservationStatus'] == 'Cancelled')
        {
         
            $cars->update([
                'IsReserved' => false
            ]);
        }
        
        
        
        $reservationView = DB::table('current_reservations_v')->where('id',$reservation->id)->first();
     
        return response()->json($reservationView);
    }
 
    public function reservationNo() {
       $lastReservation =  Reservation::orderBy('created_at','desc')->first();
       return (!empty($lastReservation)) ? $lastReservation->ReservationNo+1 : 1;
     }
     
    public function invoice( $reservationId, $carId, $unitPrice, $sembol,$currencyType ) {
        $cars = Cars::find($carId);
        $lastInvoice = Invoice::orderBy('created_at','desc')->first();
        
        $InvoiceNo = is_numeric($lastInvoice->InvoiceNo) ? $lastInvoice->InvoiceNo + 1 : $lastInvoice->InvoiceNo.'00' ;
        
        $vat = 5;
        $vatTotal = ($unitPrice * $vat) / 100;
        $subTotal = $unitPrice - $vatTotal;
        return [
            'reservation_id' => $reservationId,
            'InvoiceNo' => $InvoiceNo,
            'InvoiceCar' => $cars->LicencePlate." ARAÇ KİRALAMA",
            'UnitPrice' => $unitPrice,
            'Piece' => 1,
            'VatRate' => $vat,
            'UnitTotal' => $unitPrice,
            'SubTotal' => $subTotal,
            'VatTotal' => $vatTotal,
            'Total' => $subTotal,
            'TotalSting' => $this->moneyToSting($unitPrice,'.',$sembol,$currencyType)
        ];
     }
     
    public function receipt($invoiceId,$invoiceNo,$reservationId,$total,$userId,$sembol,$currencyType) {
         $lastReceipt = ReceiptCollection::orderBy('created_at','desc')->first();
         $receiptNo = is_numeric($lastReceipt->ReceiptCollectionNo) ? $lastReceipt->ReceiptCollectionNo + 1 : $lastReceipt->ReceiptCollectionNo.'00' ;
         $user = Customer::find($userId);
         
        return [
             'invoice_id' => $invoiceId,  
             'reservation_id' => $reservationId,  
             'ReceiptCollectionNo' => $receiptNo,  
             'MessageContent' => 'SAYIN '.$user->Name." ".$user->Surname. ' den/dan '.$invoiceNo.";"."NO'LU ARAÇ KİRALAMA Bedeli karşılığında ".$this->moneyToSting($total,'.',$sembol,$currencyType)." teşekkürlerle alınmıştır.",  
        ];
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
    
    public function updateReservationNumber(\Illuminate\Http\Request $request) {
        
        $reservation = Reservation::findOrFail($request->id);
        $reservation->update([
           'ReservationNo' => $request->ReservationNo
        ]);
        return response()->json([
            'reservation_id' => $reservation->id,
            'ReservationNo' => $reservation->ReservationNo
        ]);
    }
    
    public function renewReservationPaymentMethod( ReservationRenewPaymentRequest $request) {
        
   
        $reservation = Reservation::findOrFail($request->id);
//        $data = collect($request->validated());
//        unset($data['id']);
        $reservation->update($request->validated());

        $reservationView = DB::table('current_reservations_v')->where('id',$reservation->id)->first();
        return response()->json($reservationView);
    }
    
    public function updateReservations(ReservationAllUpdatesRequest $request,$id){
        $oldReservation = Reservation::find($id);
        $reservationCreate = Reservation::create($request->validated()+['ParentReservationId'=> $id,'ReservationNo' => $this->reservationNo(),'ReservationRemarks' => $oldReservation->ReservationRemarks]);

        if((int) $request->validated()['TotalPrice'] > 0){
            $invoice = $this->invoice(
                $reservationCreate->id,
                $request->validated()['cars_id'],
                $request->validated()['TotalPrice'],
                $request->validated()['CurrencySymbol'],
                $request->validated()['CurrencyType']
            );

            $invoicePrint = Invoice::create($invoice);

            $reciept = $this->receipt(
                $invoicePrint->id,
                $invoicePrint->InvoiceNo,
                $reservationCreate->id,
                $invoicePrint->UnitTotal,
                $reservationCreate->customers_id,
                $request->validated()['CurrencySymbol'],
                $request->validated()['CurrencyType']
            );
            ReceiptCollection::create($reciept);
        }
          
     

        
        if ($request->has('reservation_drivers'))
        {
            $drivers = [];
            
            foreach (json_decode($request->reservation_drivers) as $driver){
                $drivers[] = [
                  'reservation_id' => $reservationCreate->id,
                  'driver_id' => $driver  
                ];
            }
            ReservationDriver::insert($drivers);
        }
        $updatedReservation = DB::table('current_reservations_v')->where('id','=',$reservationCreate->ParentReservationId)->first();
        return response()->json($updatedReservation,200);
    }
}
