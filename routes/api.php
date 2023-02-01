<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::get('/files/{path}/{fileName}',[\App\Http\Controllers\GiveImages::class,'index']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

    Route::post('auth-login',[\App\Http\Controllers\Auth\AuthController::class,'login'])->name('login');
                                   //jwt.verify
    Route::group(['middleware' => ['auth:sanctum', 'verify-api']],
        function () {
            //
            Route::resource('car-brands', \App\Http\Controllers\Cars\CarBrandController::class);
            Route::resource('car-models', \App\Http\Controllers\Cars\CarModelController::class);
            Route::resource('car-body-types', \App\Http\Controllers\Cars\CarTypesController::class);
            Route::resource('car-fuel-types', \App\Http\Controllers\Cars\CarFuelTypesController::class);
            Route::resource('car-transmissions', \App\Http\Controllers\Cars\CarTransmissionTypesController::class);
            Route::resource('car-classes', \App\Http\Controllers\Cars\CarClassesController::class);
            Route::resource('car-prices', \App\Http\Controllers\Cars\CarPricesController::class);
            Route::resource('company-detail', \App\Http\Controllers\Company\CompanyDetailsController::class);
            Route::post('auth-register', [\App\Http\Controllers\Auth\AuthController::class, 'register']);
            Route::resource('countries', \App\Http\Controllers\Address\CountryController::class);
            Route::resource('cities', \App\Http\Controllers\Address\CitiesController::class);
            Route::resource('car-season-prices', \App\Http\Controllers\Cars\CarSeasonPricesController::class);

//            Route::resource('districts', \App\Http\Controllers\Address\DistrictsController::class);
            Route::resource('customers', \App\Http\Controllers\Users\CustomerController::class);
            Route::resource('customer-groups', \App\Http\Controllers\Users\CustomerGroupController::class);
            Route::resource('customer-documents', \App\Http\Controllers\Users\CustomerDocumentController::class);
            Route::resource('customer-drivers', \App\Http\Controllers\Users\CustomerDriversController::class);
               Route::resource('customer-units', \App\Http\Controllers\Users\CustomerUnitController::class);
            Route::resource('districts', \App\Http\Controllers\Address\DistrictsController::class);
            Route::resource('offices', \App\Http\Controllers\OfficeController::class);
            Route::resource('cars', \App\Http\Controllers\Cars\CarsController::class);
            Route::post('find-car-by-licence-plate', [\App\Http\Controllers\Cars\CarsController::class,'findCarByLicencePlate']);
            Route::get(      'filter-assistance-cars/{licencePlate}', [\App\Http\Controllers\Cars\CarsController::class, 'filterAssistanceCars']);
            Route::post(      'filter-cars', [\App\Http\Controllers\Cars\CarsController::class, 'filterCars']);
            Route::post(      'cars-details', [\App\Http\Controllers\Cars\CarsController::class,'getCarsDetails']);
            Route::resource('machinist-types', \App\Http\Controllers\Machinist\MachinistTypeController::class);
            Route::resource('machinist-companies', \App\Http\Controllers\Machinist\MachinistController::class);
            Route::resource('extra-services', \App\Http\Controllers\ExtraController::class);
            Route::resource('car-damages', \App\Http\Controllers\CarDamageController::class);
            Route::resource('machinist-car-damage', \App\Http\Controllers\Machinist\MachinistDamageRegistrationController::class);
            Route::get('active-machinist-registrations', [\App\Http\Controllers\Machinist\MachinistDamageRegistrationController::class,'activeMachinistRegistrations']);

            //****************************** FILE DOWNLOAD ********************************//
            Route::get('file-download/{folder}/{fileName}', [\App\Http\Controllers\FileDownloader::class, 'downloadFile']);
            Route::resource('transaction',\App\Http\Controllers\Payment::class);
            Route::get('check-transaction/{id}',[\App\Http\Controllers\Payment::class,'checkTransaction']);
            
            
            //****************************** RESERVATIONS ********************************//
            Route::resource('reservations',App\Http\Controllers\Reservation\ReservationController::class);
            Route::post('renew-reservation-payment-method',[App\Http\Controllers\Reservation\ReservationController::class,'renewReservationPaymentMethod']);
            Route::post('update-reservation-number',[\App\Http\Controllers\Reservation\ReservationController::class,'updateReservationNumber']);
            Route::put('reservation-update/{id}',[\App\Http\Controllers\Reservation\ReservationController::class,'updateReservations']);
            Route::get('current-reservations',[\App\Http\Controllers\Reservation\ReservationController::class,'currentReservations']);
            Route::get('old-reservations',[\App\Http\Controllers\Reservation\ReservationController::class,'oldReservations']);
            Route::get('export-current-reservation',[\App\Http\Controllers\Reservation\ReservationController::class,'exportCurrentReservation']);
            Route::get('export-all-reservation',[\App\Http\Controllers\Reservation\ReservationController::class,'exportAllReservations']);
            Route::post('reservation-report-export',[App\Http\Controllers\ReportsController::class,'reservationReportDownload']);
            Route::get('send-reservation-agreement-to-mail/{id}',[\App\Http\Controllers\Agreement::class,'sendMail']);
            Route::post('reservation-reports',[App\Http\Controllers\ReportsController::class,'reservationReport']);
            Route::post('reservation-reports-date',[App\Http\Controllers\ReportsController::class,'reservationReportDates']);

            Route::get('reservation-agreement/{id}',[\App\Http\Controllers\Agreement::class,'download']);
            Route::post('export-all-report',[App\Http\Controllers\ReportsController::class,'exportExelFiles']);
            //****************************** REGISTER ******************************** //
            Route::post('register',[\App\Http\Controllers\Auth\AuthController::class,'register']);
            Route::resource('users',\App\Http\Controllers\Auth\AuthController::class );

            Route::get('export-machinist-reservation',[\App\Http\Controllers\Machinist\MachinistDamageRegistrationController::class,'export']);
            Route::get('export-machinist',[\App\Http\Controllers\Machinist\MachinistController::class,'export']);
            Route::get('export-cars',[App\Http\Controllers\Cars\CarsController::class,'export']);

            Route::resource('invoice',\App\Http\Controllers\InvoiceController::class);
            Route::post('update-invoice-number',[\App\Http\Controllers\InvoiceController::class,'updateInvoiceUpdate']);
            Route::get('invoice-download/{id}',[\App\Http\Controllers\InvoiceController::class,'invoiceDownload']);
            Route::get('invoice-send-mail/{id}',[\App\Http\Controllers\InvoiceController::class,'sendMailToCustomer']);
            Route::post('invoice-report',[\App\Http\Controllers\InvoiceController::class,'invoiceReport']);
            
            Route::resource('receipt',\App\Http\Controllers\ReceiptCollectionController::class);
            Route::post('update-receipt-number',[\App\Http\Controllers\ReceiptCollectionController::class,'updateReceiptUpdate']);
            Route::get('receipt-download/{id}',[\App\Http\Controllers\ReceiptCollectionController::class,'receiptDownload']);
            Route::get('receipt-send-mail/{id}',[\App\Http\Controllers\ReceiptCollectionController::class,'sendMailToCustomer']);
            
            Route::resource('foreign-sale',\App\Http\Controllers\ForeignSaleController::class);
            Route::get('invoice-sales-download/{id}',[\App\Http\Controllers\ForeignSaleController::class,'download']);
            Route::get('invoice-sales--collection-download/{id}',[\App\Http\Controllers\ForeignSaleController::class,'downloadReceipt']);




            //****************************** Car Seyrusefer api ********************************//
            Route::resource('seyrusefer-cars',\App\Http\Controllers\CarSeyruSeferController::class);
            Route::get('seyrusefer-download/{id}',[\App\Http\Controllers\CarSeyruSeferController::class,'getCarSeyruseferDownload']);
            Route::resource('car-inspections',\App\Http\Controllers\CarInspectionController::class);
            Route::post('car-inspections-multiple',[App\Http\Controllers\CarInspectionController::class,'multipleSave']);


            Route::get('notifications',[App\Http\Controllers\Dashboard::class,'notifications']);
            Route::post('mark-notifications',[App\Http\Controllers\Dashboard::class,'markNotification']);



            //****************************** Car Insurance  ********************************//
            Route::resource('insurance-cars',\App\Http\Controllers\CarInsuranceController::class);
            Route::get('insurance-download/{id}',[\App\Http\Controllers\CarInsuranceController::class,'getCarInsuranceDownload']);
        });
#********************************* Tablet api **********************************#

Route::group(['prefix' => 'tablet','middleware' => ['verify-tablet']], function () {

    Route::get('customers',[\App\Http\Controllers\Users\CustomerController::class,'index']);
    Route::get('offices',[\App\Http\Controllers\OfficeController::class,'index']);
    Route::post('search-customer',[\App\Http\Controllers\Users\CustomerController::class,'searchCustomer']);
    Route::post('create-customer',[\App\Http\Controllers\Users\CustomerController::class,'store']);
    Route::put('update-customer/{id}',[\App\Http\Controllers\Users\CustomerController::class,'update']);
    Route::post('create-customer-document',[\App\Http\Controllers\Users\CustomerDocumentController::class,'createDocument']);
    Route::post(      'filter-cars', [\App\Http\Controllers\Cars\CarsController::class, 'filterCars']);

    Route::get('car-brands', [\App\Http\Controllers\Cars\CarBrandController::class,'index']);
    Route::get('car-models', [\App\Http\Controllers\Cars\CarModelController::class,'index']);
    Route::get('car-transmissions', [\App\Http\Controllers\Cars\CarTransmissionTypesController::class,'index']);
    Route::get('car-classes', [\App\Http\Controllers\Cars\CarClassesController::class,'index']);
    Route::get('extra-services', [\App\Http\Controllers\ExtraController::class,'index']);
    Route::post('create-reservation',[\App\Http\Controllers\Reservation\ReservationController::class,'store']);

});


#********************************* FRONT WEB PAGE API **********************************#

Route::group(['prefix' => 'fapi','middleware' => ['verify-api' ]],function () {

    Route::get('car/car-brands',[\App\Http\Controllers\API\CarsController::class,'brands']);
    Route::get('car/car-models',[\App\Http\Controllers\API\CarsController::class,'models']);
    Route::get('car/car-body-types',[\App\Http\Controllers\API\CarsController::class,'bodyTypes']);
    Route::get('car/car-classes',[\App\Http\Controllers\API\CarsController::class,'classes']);
    Route::get('car/car-fuel-types',[\App\Http\Controllers\API\CarsController::class,'fuelTypes']);
    Route::get('car/car-transmission-types',[\App\Http\Controllers\API\CarsController::class,'transmissionTypes']);
    Route::get('car/car-types',[\App\Http\Controllers\API\CarsController::class,'types']);



    Route::get('locations',[\App\Http\Controllers\API\CompanyDetail::class,'locations']);
    Route::get('company/countries',[\App\Http\Controllers\API\CompanyDetail::class,'countries']);
    Route::get('company/cities',[\App\Http\Controllers\API\CompanyDetail::class,'cities']);
    Route::get('company/extra-products',[\App\Http\Controllers\API\CompanyDetail::class,'extraProducts']);
    Route::post('contact', [\App\Http\Controllers\API\AuthController::class,'contactForm']);

    Route::post('cars-search',[\App\Http\Controllers\API\CarsController::class,'searchCar']);

    Route::resource('guest-reservation',\App\Http\Controllers\API\GuestReservationController::class);

    Route::resource('third-party-reservation',\App\Http\Controllers\API\ThirdPartyReservationController::class);

    Route::post('guest-reservation/confirm',[\App\Http\Controllers\API\GuestReservationController::class,'confirmReservation']);
    Route::post('re-pay',[\App\Http\Controllers\API\GuestReservationController::class,'rePayReservation']);

    Route::post('user/register',[\App\Http\Controllers\API\AuthController::class,'register']);
    Route::post('user/activate-account',[\App\Http\Controllers\API\AuthController::class,'activateAccount']);
    Route::post('user/login',[\App\Http\Controllers\API\AuthController::class,'login']);
    Route::post('user/get-new-password', [\App\Http\Controllers\API\AuthController::class,'getNewPassword']);


    Route::get('cars',[\App\Http\Controllers\API\CarsController::class,'cars']);
});

Route::group(['prefix' => 'fapi','middleware' => ['auth:sanctum','verify-api' ]],function () {
    Route::get('user/logout', [\App\Http\Controllers\API\AuthController::class,'logout']);
    Route::post('user/unsubscribe', [\App\Http\Controllers\API\AuthController::class,'unsubscribe']);
    Route::post('user/reset-password',[\App\Http\Controllers\API\AuthController::class, 'resetPassword']);
    Route::get('user/dashboard',[\App\Http\Controllers\API\AuthController::class, 'dashboard']);
    Route::resource('reservations',\App\Http\Controllers\API\CustomerReservations::class);
    Route::post('reservations/confirm',[\App\Http\Controllers\API\CustomerReservations::class,'confirmReservation']);
    Route::get('test-et',[\App\Http\Controllers\API\AuthController::class,'checkUser']);
});
