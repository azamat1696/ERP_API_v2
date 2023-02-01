<?php
namespace App\Helpers;
use App\Models\CompanyDetails;
use App\Models\ReservationDriver;
use Illuminate\Support\Facades\DB;
use PDF;
class PrepareMailAgreement {
    public $reservationId;
    public $reservationDetail;
    public $pdfName;
    public function __construct($reservationId)
    {
        $this->reservationId = $reservationId;
        $this->init();
    }

    public function init() {
        
        $this->reservationDetail = DB::table('reservation_agreement_v')->where('reservation_id','=',$this->reservationId)->first();
        $invoiceCar = $this->invoiceCar();
        $customer = $this->invoiceCustomer();
        $damagePointer = $this->agreementDamagePointer();
        $reservationDrivers = $this->invoiceCustomerDrivers();
        $reservationPrices = $this->invoicePrices();
        $pdf = PDF::loadView('Corparate.Agreement',
            compact('invoiceCar',
                'customer',
                'damagePointer',
                'reservationDrivers',
                'reservationPrices'
            ))->setPaper('a4', 'portrait');
        $this->pdfName = rand(1111111,999999999).".pdf";
        $pdf->save(public_path('uploads/mail/'.$this->pdfName) );
    }
    public function invoiceCar() {
        return [
            'BrandAndModel' => $this->reservationDetail->BrandName  .' '. $this->reservationDetail->ModelName,
            'ReservationNumber' => $this->reservationDetail->ReservationNo,
            'ClassName' => $this->reservationDetail->ClassName,
            'EngineCapacity' => $this->reservationDetail->EngineCapacity,
            'Year' => $this->reservationDetail->Year,
            'FuelTypeName' => $this->reservationDetail->FuelTypeName,
            'FuelTank' => '50%',
            'StartDate' => $this->reservationDetail->StartDate,
            'StartTime' => $this->reservationDetail->StartTime,
            'EndDate' => $this->reservationDetail->EndDate,
            'EndTime' => $this->reservationDetail->EndTime,
            'PickupLocation' => $this->reservationDetail->PickupLocation,
            'DropLocation' => $this->reservationDetail->DropLocation,
            'CarTransmissionName' => $this->reservationDetail->CarTransmissionName,
        ];
    }
    public function invoiceCustomer() {
        return [
            'CustomerNameSurname' => $this->reservationDetail->CustomerNameSurname,
            'CustomerType' => ($this->reservationDetail->CustomerType == 'Corporate') ? 'Kurumsal' : 'Bireysel',
            'CustomerEmail' => $this->reservationDetail->Email,
            'CustomerPhone' => $this->reservationDetail->Phone,
            'CustomerSignature' => $this->reservationDetail->CustomerSignature,
            'PersonalSignature' => $this->reservationDetail->PersonalSignature,
        ];
    }
    public function invoiceCustomerDrivers() {
        return ReservationDriver::with('driver')->where('reservation_id','=',$this->reservationId)->get();
    }
    public function invoicePrices() {
        return [
            'RentDays' => $this->reservationDetail->RentDays,
            'DailyRentPrice' => $this->reservationDetail->DailyRentPrice,
            'TotalRentPrice' => $this->reservationDetail->TotalRentPrice,
            'CurrencyRate' => $this->reservationDetail->CurrencyRate,
            'CurrencyType' => $this->reservationDetail->CurrencyType,
            'CurrencySymbol' => $this->reservationDetail->CurrencySymbol,
            'TotalPrice' => $this->reservationDetail->TotalPrice,
            'ExtraServices' => $this->reservationDetail->ExtraServices,

        ];
    }
    public function invoiceTerms() {

    }
    public function invoiceCarDamages() {

    }
    public function companyDetails() {
        $detail = CompanyDetails::take(1)->first()->toArray();
        return [
            
        ];
    }
    public function agreementDamagePointer() {

        return ' <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="250px" height="200px" viewBox="0 0 498.4 623" enable-background="new 0 0 498.4 623" xml:space="preserve">
                                                                                            <path fill="none" class="inactive" stroke="#000000" stroke-width="2" stroke-miterlimit="10" d="M26.7,210.3c0,0,7.4,1.4,11.3,1.4

                                            	c25.4,0,46-20.6,46-46s-20.6-46-46-46c-4,0-7.8,0.5-11.5,1.4l4-50.6c0,0,11.5-10.1,21.6-10.1s35.4,0,35.4,0s32.2,23.9,40.9,123.2

                                            	c0,0,44.6,74.9,51.5,134.2s6,125-2.3,164.5c0,0-24.4,59.3-63.9,64.3c0,0-23,0.5-29,15.6H59.4c0,0-24.4-5.5-24.4-20.2v-21l2.3-1

                                            	c25.4,0,46-20.6,46-46s-20.6-46-46-46c-4,0-7.8,0.5-11.5,1.4L26.7,210.3z"></path>
                                <path class="js_car-part" data-id="A30" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M175.1,291.5l-5.8,2.6c0,0,6.7,24.4,7.7,64.8c0.9,40.4,0.8,62,0.8,62s-0.2,12.9-3.5,24.4l-0.8,32.2l3.5,7c0,0,6.6-23,7.2-61.6

                                            	c0.6-38.6-0.9-72.9-2.1-88.2C180.6,317.5,175.1,291.5,175.1,291.5z"></path>
                                <path class="js_car-part" data-id="A12L" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M137.6,465.8l3.4,31.4c0,0-7.1,5.6-8.4,6.7c0,0-23.1,9.3-32.6,20.1l-23.2-26.8c0,0,7.8-9.7,6.3-24.8c-1.5-15.2-5.2-20.1-5.2-20.1

                                            	s-7.7-13.1-18.2-18.4c-10.5-5.3-19.2-6.2-19.2-6.2V414l37.1,24.9l37.8,26.4L137.6,465.8z"></path>
                                <path class="js_car-part" data-id="A3L" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M116.3,219.5c0,0-0.2-68.9-5.7-91c0,0-1.3,11.5-5.6,14.5c0,0-5.1-7.4-7.7-13.6l-17.8,15.3c0,0,6.4,11.8,4.2,26.7

                                            	c-2.2,14.8-9.7,24.4-15.2,29c-4.8,4-14.4,11.1-27.6,11.1v10.1C40.9,221.5,94.8,216.7,116.3,219.5z"></path>
                                <path class="js_car-part" data-id="A13L" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M75.6,474.2c0-20.8-16.9-37.7-37.7-37.7S0.3,453.4,0.3,474.2s16.9,37.7,37.7,37.7C58.7,511.9,75.6,495,75.6,474.2z M8.6,474.2

                                            	c0-16.2,13.1-29.3,29.3-29.3c16.2,0,29.3,13.1,29.3,29.3s-13.1,29.3-29.3,29.3S8.6,490.4,8.6,474.2z"></path>
                                <path class="js_car-part" data-id="A4L" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M75.6,165.7c0-20.8-16.9-37.7-37.7-37.7S0.3,144.9,0.3,165.7s16.9,37.7,37.7,37.7C58.7,203.4,75.6,186.5,75.6,165.7z M8.6,165.7

                                            	c0-16.2,13.1-29.3,29.3-29.3c16.2,0,29.3,13.1,29.3,29.3S54.1,195,37.9,195S8.6,181.9,8.6,165.7z"></path>
                                <path class="js_car-part" data-id="A5L" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M40.1,427.8l-0.3-216.5c0,0-9.9-0.6-13.1-1.7l-0.8,219.9C25.8,429.5,34,427.5,40.1,427.8z"></path>
                                <path class="js_car-part" data-id="A2L" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M97.1,129.4c0,0-11-19.8-8.1-57.4l1.5,1.6l3.8-6l-6.8-7.1H49.1c0,0-15.9,4.8-18.6,10.1l-4.4,49.9c0,0,20.5-2.8,32.9,3.9

                                            	S79.2,145,79.2,145L97.1,129.4z"></path>
                                <path class="js_car-part" data-id="A15L" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M99.7,524.1l-23-26.1c0,0-10.4,15.2-21.9,18.7S38,519.5,38,519.5l-3.2,2.1l0.2,18.6c0,0-2,15.4,24.5,21.6l25-0.6

                                            	C84.5,561.3,83.1,539.9,99.7,524.1z"></path>
                                <path class="js_car-part" data-id="A10" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M128.3,183.6c0,0-6.3,5.1-12.2,14.5c0,0-1.6-61.1-9-84.3c-7.4-23.2-16.5-41.4-16.5-41.4l3.4-5.3C94.1,67.1,119.6,94,128.3,183.6z"></path>
                                <path class="js_car-part" data-id="A16L" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M176.4,484.9l-0.1-0.2l-3.3-6.2l-15.6,12c0,0-14.5,4.5-23.7,12.8c0,0-50.2,17-48.5,56.9l2.8-2.9c0,0,9-10.3,27.6-11.3

                                            	C134.1,545.1,157.3,525.3,176.4,484.9z"></path>
                                <path class="js_car-part" data-id="A14L" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M157.3,490.4c0,0-40.7,13.2-43.8,46.6C113.5,537,140.4,530,157.3,490.4z"></path>
                                <path class="js_car-part" data-id="A1L" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M89,71.9c0.1-1,15.9,24.8,20.5,53.6c0,0,1.5,10.9-4.9,17.5C104.6,143,83.5,113.3,89,71.9z"></path>
                                <path class="js_car-part" data-id="A0L" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M43.7,71.6c-1.1-0.2-2.4-0.2-3.7,0.3c-3.1,1.2-3.4,7.4-1.8,16.2c1.5,8.9,4,13.8,10.4,11c5.9-2.5,10.5-9.8,0.7-23.1

                                            	C48.4,75,45.2,71.9,43.7,71.6z"></path>
                                <path class="js_car-part" data-id="A11L" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M169.9,449.1l-29.1,18.7c0,0,3.3,19.1,17.8,13.5C164,479.1,169.9,449.1,169.9,449.1z"></path>
                                <path class="js_car-part" data-id="A20" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M131.1,188.4c0,0-5.7,5.3-8.3,9.9c0,0,29,39.1,46.2,95.4l5.3-2.3C174.3,291.4,166.3,250.3,131.1,188.4z"></path>
                                <path class="js_car-part" data-id="A40" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M135.9,538.2v-15.4c0,0,12.8-11.1,20.5-31.1l16.5-13.2l3.3,6.2C176.3,484.7,159,523.8,135.9,538.2z"></path>
                                <path class="js_car-part" data-id="A9L" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M169.9,445.1c0,0,4.9-14.1,4.9-30c0-9.2-0.9-51.5-0.9-51.5c-7-3.9-20.8-6.8-33.4-8.2c-13.9-1.6-26.3-1.6-26.3-1.6H40l0.3,60.4

                                            	c37.4,22.7,75.4,51.5,75.4,51.5h22.7L169.9,445.1z M132.2,360.5c19.5,0.5,38.1,6.9,38.1,6.9s0.7,41.4,0.7,51.9s-4.6,22.7-4.6,22.7

                                            	l-28.8,17.3L132.2,360.5z"></path>
                                <path class="js_car-part" data-id="A8L" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M173.5,358.7c-0.9-17.5-3.7-41.1-3.7-41.1c-7-46.3-53.6-117.6-53.6-117.6v19.3c-36.5-2.5-76,2.5-76,2.5v128.4c0,0,57-0.6,82.7,0

                                            	C148.7,350.7,173.5,358.7,173.5,358.7z M129.9,344.5l-11.3-115.3l7.6-4.4c20.1,35.6,31.7,63,37,83.2c2.3,8.8,3.9,22.3,3.9,22.3

                                            	l1.8,20.7C147.6,345.4,129.9,344.5,129.9,344.5z"></path>
                                <path fill="none" class="inactive" stroke="#000000" stroke-width="2" stroke-miterlimit="10" d="M471.7,210.3c0,0-7.4,1.4-11.3,1.4

                                            	c-25.4,0-46-20.6-46-46s20.6-46,46-46c4,0,7.8,0.5,11.5,1.4l-4-50.6c0,0-11.5-10.1-21.6-10.1s-35.4,0-35.4,0S378.8,84.3,370,183.6

                                            	c0,0-44.6,74.9-51.5,134.2s-6,125,2.3,164.5c0,0,24.4,59.3,63.9,64.3c0,0,23,0.5,29,15.6H439c0,0,24.4-5.5,24.4-20.2v-21l-2.3-1

                                            	c-25.4,0-46-20.6-46-46s20.6-46,46-46c4,0,7.8,0.5,11.5,1.4L471.7,210.3z"></path>
                                <path class="js_car-part" data-id="A30" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M323.3,291.5l5.8,2.6c0,0-6.7,24.4-7.7,64.8c-0.9,40.4-0.8,62-0.8,62s0.2,12.9,3.5,24.4l0.8,32.2l-3.5,7c0,0-6.6-23-7.2-61.6

                                            	c-0.6-38.6,0.9-72.9,2.1-88.2C317.8,317.5,323.3,291.5,323.3,291.5z"></path>
                                <path class="js_car-part" data-id="A12R" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M360.7,465.8l-3.4,31.4c0,0,7.1,5.6,8.4,6.7c0,0,23.1,9.3,32.6,20.1l23.2-26.8c0,0-7.8-9.7-6.3-24.8s5.2-20.1,5.2-20.1

                                            	s7.7-13.1,18.2-18.4c10.5-5.3,19.2-6.2,19.2-6.2V414l-37.1,24.9l-37.8,26.4L360.7,465.8z"></path>
                                <path class="js_car-part" data-id="A3R" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M382.1,219.5c0,0,0.2-68.9,5.7-91c0,0,1.3,11.5,5.6,14.5c0,0,5.1-7.4,7.7-13.6l17.8,15.3c0,0-6.4,11.8-4.3,26.7

                                            	c2.2,14.8,9.7,24.4,15.2,29c4.8,4,14.4,11.1,27.6,11.1v10.1C457.5,221.5,403.6,216.7,382.1,219.5z"></path>
                                <path class="js_car-part" data-id="A13R" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M422.8,474.2c0-20.8,16.9-37.7,37.7-37.7c20.8,0,37.7,16.9,37.7,37.7s-16.9,37.7-37.7,37.7C439.6,511.9,422.8,495,422.8,474.2z

                                            	 M489.8,474.2c0-16.2-13.1-29.3-29.3-29.3c-16.2,0-29.3,13.1-29.3,29.3s13.1,29.3,29.3,29.3C476.7,503.5,489.8,490.4,489.8,474.2z"></path>
                                <path class="js_car-part" data-id="A4R" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M422.8,165.7c0-20.8,16.9-37.7,37.7-37.7c20.8,0,37.7,16.9,37.7,37.7s-16.9,37.7-37.7,37.7C439.6,203.4,422.8,186.5,422.8,165.7z

                                            	 M489.8,165.7c0-16.2-13.1-29.3-29.3-29.3c-16.2,0-29.3,13.1-29.3,29.3s13.1,29.3,29.3,29.3C476.7,195,489.8,181.9,489.8,165.7z"></path>
                                <path class="js_car-part" data-id="A5R" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M458.3,427.8l0.3-216.5c0,0,9.9-0.6,13.1-1.7l0.8,219.9C472.6,429.5,464.4,427.5,458.3,427.8z"></path>
                                <path class="js_car-part" data-id="A2R" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M401.3,129.4c0,0,11-19.8,8.1-57.4l-1.5,1.6l-3.8-6l6.8-7.1h38.4c0,0,15.9,4.8,18.6,10.1l4.4,49.9c0,0-20.5-2.8-32.9,3.9

                                            	C427,131,419.2,145,419.2,145L401.3,129.4z"></path>
                                <path class="js_car-part" data-id="A15R" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M398.7,524.1l23-26.1c0,0,10.4,15.2,21.9,18.7c11.5,3.5,16.8,2.9,16.8,2.9l3.2,2.1l-0.2,18.6c0,0,2,15.4-24.5,21.6l-25-0.6

                                            	C413.9,561.3,415.3,539.9,398.7,524.1z"></path>
                                <path class="js_car-part" data-id="A10" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M370,183.6c0,0,6.3,5.1,12.2,14.5c0,0,1.6-61.1,9-84.3c7.4-23.2,16.5-41.4,16.5-41.4l-3.4-5.3C404.3,67.1,378.8,94,370,183.6z"></path>
                                <path class="js_car-part" data-id="A16R" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M322,484.9l0.1-0.2l3.3-6.2l15.6,12c0,0,14.5,4.5,23.7,12.8c0,0,50.2,17,48.5,56.9l-2.8-2.9c0,0-9-10.3-27.6-11.3

                                            	S341.1,525.3,322,484.9z"></path>
                                <path class="js_car-part" data-id="A14R" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M341.1,490.4c0,0,40.7,13.2,43.8,46.6C384.9,537,357.9,530,341.1,490.4z"></path>
                                <path class="js_car-part" data-id="A1R" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M409.4,71.9c-0.1-1-15.9,24.8-20.5,53.6c0,0-1.5,10.9,4.9,17.5C393.8,143,414.9,113.3,409.4,71.9z"></path>
                                <path class="js_car-part" data-id="A0R" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M454.7,71.6c1.1-0.2,2.4-0.2,3.7,0.3c3.1,1.2,3.4,7.4,1.8,16.2c-1.5,8.9-4,13.8-10.4,11c-5.9-2.5-10.5-9.8-0.7-23.1

                                            	C450,75,453.2,71.9,454.7,71.6z"></path>
                                <path class="js_car-part" data-id="A11R" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M328.5,449.1l29.1,18.7c0,0-3.3,19.1-17.8,13.5C334.4,479.1,328.5,449.1,328.5,449.1z"></path>
                                <path class="js_car-part" data-id="A20" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M367.3,188.4c0,0,5.7,5.3,8.3,9.9c0,0-29,39.1-46.2,95.4l-5.3-2.3C324.1,291.4,332.1,250.3,367.3,188.4z"></path>
                                <path class="js_car-part" data-id="A40" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M362.5,538.2v-15.4c0,0-12.8-11.1-20.5-31.1l-16.5-13.2l-3.3,6.2C322.1,484.7,339.4,523.8,362.5,538.2z"></path>
                                <path class="js_car-part" data-id="A9R" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M328.5,445.1c0,0-4.9-14.1-4.9-30c0-9.2,0.9-51.5,0.9-51.5c7-3.9,20.8-6.8,33.4-8.2c13.9-1.6,26.3-1.6,26.3-1.6h74.1l-0.3,60.4

                                            	c-37.4,22.7-75.4,51.5-75.4,51.5h-22.7L328.5,445.1z M366.1,360.5c-19.5,0.5-38.1,6.9-38.1,6.9s-0.7,41.4-0.7,51.9

                                            	s4.6,22.7,4.6,22.7l28.8,17.3L366.1,360.5z M366.1,360.5c-19.5,0.5-38.1,6.9-38.1,6.9s-0.7,41.4-0.7,51.9s4.6,22.7,4.6,22.7

                                            	l28.8,17.3L366.1,360.5z"></path>
                                <path class="js_car-part" data-id="A8R" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M324.9,358.7c0.9-17.5,3.7-41.1,3.7-41.1c7-46.3,53.6-117.6,53.6-117.6v19.3c36.5-2.4,76,2.5,76,2.5v128.4c0,0-57-0.6-82.7,0

                                            	C349.7,350.7,324.9,358.7,324.9,358.7z"></path>
                                <path class="js_car-part" data-id="A30" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M317.5,282.4c0,0-11.9,117.6-8.3,199.1h-118c0,0-3.4-158.1-10.4-198.5c0,0,38.9-3.2,75.7-3.4C287.5,279.5,317.3,282.2,317.5,282.4z"></path>
                                <path class="js_car-part" data-id="A20" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M317.5,282.4l13.2-91c0,0-8.3-31.9-77.8-31.9s-83,25.4-83,25.4l11,98C180.9,283,276.2,276.3,317.5,282.4z"></path>
                                <path class="js_car-part" data-id="A40" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M309.3,481.6c0,0,11,1.5,12.9,10.7c1.8,9.2-4.9,40.1-39.5,45.6s-66.8,0.6-66.8,0.6s-38-2.8-40.7-42.9c0,0,1.2-14.1,16.2-14.1

                                            	S309.7,482,309.3,481.6z"></path>
                                <path class="js_car-part" data-id="A50" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M321.2,504.8c0,0,10.7,9.5,10.7,42.9c0,0,21.8,13.5,21.8,30.9H143.8c0,0,8-21.4,23-28.2c0,0-5.2-25.1,9.5-46c0,0,4.9,25.4,30.6,32

                                            	c11.8,3,26.5,4,39.1,4.1c14.9,0.1,38.6-0.7,51-6.9C306.7,529,316.6,520.4,321.2,504.8z"></path>
                                <path class="js_car-part" data-id="A60" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M353.7,578.7H144.9c0,0-3.7,30.7,13.1,44h182.4C340.4,622.7,353.7,616.2,353.7,578.7z"></path>
                                <ellipse class="js_car-part" data-id="A17R" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="331.5" cy="597.2" rx="10.6" ry="6.2"></ellipse>
                                <ellipse class="js_car-part" data-id="A17L" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="164.2" cy="597.2" rx="10.6" ry="6.2"></ellipse>
                                <path class="js_car-part" data-id="A10" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M330.7,191.4c0,0-1.8-59.3-28.4-114c0,0-18.2-8.5-52.2-8.5S198,76.1,198,76.1s-26.3,52.2-28.1,108.9c0,0,14.1-25.8,86.7-25.5

                                            	C320.4,159.7,330.7,191.4,330.7,191.4z"></path>
                                <path class="js_car-part" data-id="A14R" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M321.6,506c0,0-9.9,17-8,37.5c0,0,11.9,1.4,17.5-10.3C331,533.1,330.3,514.3,321.6,506z"></path>
                                <path class="js_car-part" data-id="A14L" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M176.1,506c0,0,9.9,17,8,37.5c0,0-11.9,1.4-17.5-10.3C166.7,533.1,167.4,514.3,176.1,506z"></path>
                                <path class="js_car-part" data-id="A1R" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M340.9,81.8c0,0-6.7-19.5-23.9-24.4h-17.9c0,0-1.4,0.7,3.2,7.1C306.9,71,319.3,81.1,340.9,81.8z"></path>
                                <path class="js_car-part" data-id="A1L" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M156.4,81.8c0,0,6.7-19.5,23.9-24.4h17.9c0,0,1.4,0.7-3.2,7.1S178,81.1,156.4,81.8z"></path>
                                <path class="js_car-part" data-id="A00" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M180.3,57.5c8.9-1.2,17.9,0,17.9,0s-0.3,5.5-3.7,8.7H303c0,0-5.3-8.7-3.9-8.7c1.4,0,17.9,0,17.9,0s12.2,4.1,17.7,13.6

                                            	c0,0,10.3,0.2,20.9-13.1c0,0,0.9-43-12.9-57.7H155c0,0-12.9,20.5-10.6,55.4c0,0,4.8,10.1,17.7,14.7

                                            	C162.1,70.3,171.4,58.6,180.3,57.5z M208.1,18.4c-2.4,0-4.4-2-4.4-4.4s2-4.4,4.4-4.4h83c2.4,0,4.4,2,4.4,4.4s-2,4.4-4.4,4.4

                                            	C291,18.4,208.1,18.4,208.1,18.4z M191.8,43.4c0,0,11.9-8,58.1-8c46.2,0,57.7,6.9,57.7,6.9L288,57.7h-78.8L191.8,43.4z"></path>
                                <path class="js_car-part" data-id="A7R" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M367.6,344.5l11.3-115.3l-7.6-4.4c-20.1,35.6-31.7,63-37,83.2c-2.3,8.8-3.9,22.3-3.9,22.3l-1.8,20.7

                                            	C349.9,345.4,367.6,344.5,367.6,344.5z"></path>
                                <path class="js_car-part" data-id="A7L" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M129.9,344.5l-11.3-115.3l7.6-4.4c20.1,35.6,31.7,63,37,83.2c2.3,8.8,3.9,22.3,3.9,22.3l1.8,20.7

                                            	C147.6,345.4,129.9,344.5,129.9,344.5z"></path>
                                <path class="js_car-part" data-id="A10L" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M132.2,360.5c19.5,0.5,38.1,6.9,38.1,6.9s0.7,41.4,0.7,51.9s-4.6,22.7-4.6,22.7l-28.8,17.3L132.2,360.5z"></path>
                                <path class="js_car-part" data-id="A10R" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M366.1,360.5c-19.5,0.5-38.1,6.9-38.1,6.9s-0.7,41.4-0.7,51.9s4.6,22.7,4.6,22.7l28.8,17.3L366.1,360.5z"></path>
                                <path class="js_car-part" data-id="A6L" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M126.3,224.7l10.1,17.9c0,0-2.8,20.5-14.9,7.8l-2.8-21.4L126.3,224.7z"></path>
                                <path class="js_car-part" data-id="A6R" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M372.1,224.7L362,242.7c0,0,2.8,20.5,14.9,7.8l2.8-21.4L372.1,224.7z"></path>
                                <path class="js_car-part" data-id="A0R" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M323,26.4c-9.5,0-14.2-3.3-14.2-8.2s4-8.8,13.6-8.8c9.5,0,17.2-0.7,17.2,8.8C339.5,28.3,332.5,26.4,323,26.4z"></path>
                                <path class="js_car-part" data-id="A0L" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="

                                            	M173.8,26.4c9.5,0,14.2-3.3,14.2-8.2s-4-8.8-13.6-8.8c-9.5,0-17.2-0.7-17.2,8.8C157.3,28.3,164.3,26.4,173.8,26.4z"></path></svg>        ';
    }
}
