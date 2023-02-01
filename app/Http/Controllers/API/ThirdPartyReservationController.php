<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\GuestReservationRequest;
use App\Http\Requests\API\ThirdPartyReservationRequest;
use App\Mail\ReservationDetailToCustomer;
use App\Models\Cars;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\ReceiptCollection;
use App\Models\Reservation;
use App\Payments\CardPlusClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ThirdPartyReservationController extends Controller
{
    protected $createNewAccount = false;

    private $guestUserDetail;
 
    public function store(ThirdPartyReservationRequest  $request): \Illuminate\Http\JsonResponse
    {

  
        $this->guestCustomerOperation($request->validated());
        
        
        $reservationDetail = $this->reservationDetail($request->validated());
  
        //*************************** SAVE TO DB ******************************//

        try {
            $reservation = Reservation::create($reservationDetail);
     
            $invoice = $this->invoice(
                $reservation->id,
                $reservation->cars_id,
                $reservation->TotalPrice, // TotalRentPrice
                $reservation->CurrencySymbol,
                $reservation->CurrencyType
            );

            $invoiceCreated =  Invoice::create($invoice);

            $receipt = $this->receipt(
                $invoiceCreated->id,
                $invoiceCreated->InvoiceNo,
                $reservation->id,
                $invoiceCreated->UnitTotal,
                $reservation->customers_id,
                $reservation->CurrencySymbol,
                $reservation->CurrencyType
            );
            ReceiptCollection::create($receipt);


            $reservationViewDetail = DB::table('current_reservations_v')
                ->where('ReservationNo','=',$reservation->ReservationNo)
                ->where('ReservationStatus','=','Continues')
                ->get()
                ->first();
            $customer = Customer::findOrFail($reservationViewDetail->CustomerID);

            $carsDetail = DB::table('cars_v')->where('id',$reservationViewDetail->cars_id)->first();


            $cars = Cars::find($reservation->cars_id);
            $cars->update([
                'IsReserved' => true,
                'offices_id' => $reservation->drop_office_id
            ]);
            Mail::to($customer->Email)->send(new ReservationDetailToCustomer($reservationViewDetail,null,$carsDetail));
            return response()->json([
                "status" => true,
                "status_code" => 201,
                "payload" => [
                    "sendMail" => true,
                    "reservationDetail" => $reservationViewDetail,
                    "cars" => $cars
                ]
            ],201);
 
            
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'status_code' => 400,
                'message' => 'Bad Request',
                'errors' => $exception->getMessage(),
            ]);
        }

    }
    public function reservationDetail(array $validatedData) :array  {
        
        return  [
            'ReservationNo' => $this->reservationNo(),
            'cars_id' => $validatedData['carId'],
            'drop_office_id' => $validatedData['dropLocationId'],
            'pickup_office_id' => $validatedData['pickupLocationId'],
            'customers_id' => $this->guestUserDetail->id,
            'StartDateTime' =>  $validatedData['reservationStartDateTime'],
            'EndDateTime'=> $validatedData['reservationEndDateTime'],
            'RentDays' => $validatedData['totalRentDay'],
            'ReservationType' => 'Günlük Dış Müşteri',
            'CurrencyType' => 'Lira',
            'CurrencySymbol' => '₺',
            'CurrencyRate' => 1,
            'SelectedPriceTitle' => 'DailyPrice',
            'DailyRentPrice' => $validatedData['dailyRentCost'],
            'RealDailyRentPrice' => $validatedData['dailyRentCost'],
            'TotalRentPrice' => $validatedData['totalDaysRentCost'],
            'TotalExtraServicesPrice' => $validatedData['extraServicesTotalCost'],
            'TotalPrice' => $validatedData['totalCost'],
            'TotalPriceByCurrency' => $validatedData['totalCost'],
            'PaymentMethod' => 'CreditCartOnOffice',
            'PaymentState' => 'Payed',
            'TransactionNo' => '',
            'ReservationStatus' => 'Continues',
            'ExtraServices' => (isset($validatedData['extraServicesProducts'])) ?json_encode($validatedData['extraServicesProducts'],true) :null,
            'ReservationRemarks' => null,
            'ReservationRentType' => 'Individual',
            'ThirdPartyReservationType' => $validatedData['ThirdPartyReservationType']
        ];
    }
    public function guestCustomerOperation(array $validatedData)  
    {
        $checkCustomerAlreadyExist = DB::table('customers')->where('Email','=',$validatedData['guestDvEmail'])->first();
        if ($checkCustomerAlreadyExist)
        {
            $this->guestUserDetail = $checkCustomerAlreadyExist;
        } else {
          $newCustomer =   Customer::create([
                'CustomerType' => 'Individual',
                'Name' => $validatedData['guestDvName'],
                'Surname' => $validatedData['guestDvSurname'],
                'Gender' => $validatedData['guestDvGender'],
                'Email' => $validatedData['guestDvEmail'],
                'Phone' => $validatedData['guestDvPhoneNo'],
                'Status' => 1
            ]);
            $this->guestUserDetail = $newCustomer;
        }
        
    }
    
    public function reservationNo() {
        $lastReservation =  Reservation::orderBy('created_at','desc')->first();
        return (!empty($lastReservation)) ? $lastReservation->ReservationNo+1 : 1;
    }


    public function invoice( $reservationId, $carId, $unitPrice, $sembol,$currencyType ) {
        $cars = Cars::find($carId);
        $lastInvoice = Invoice::orderBy('created_at','desc')->first();
        $InvoiceNo = ($lastInvoice) ? $lastInvoice->InvoiceNo+1: 1;
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
        $receiptNo = ($lastReceipt) ? $lastReceipt->ReceiptCollectionNo+1: 1;
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
}
