<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected  $fillable = [
        'ReservationNo',
        'cars_id',
        'drop_office_id',
        'pickup_office_id',
        'customer_groups_id',
        'customers_id',
        'StartDateTime',
        'EndDateTime',
        'RentDays',
        'ReservationType',
        'CurrencyType',
        'CurrencySymbol',
        'CurrencyRate',
        'SelectedPriceTitle',
        'DailyRentPrice',
        'RealDailyRentPrice',
        'TotalRentPrice',
        'TotalExtraServicesPrice',
        'TotalPrice',
        'TotalPriceByCurrency',
        'PaymentMethod',
        'PaymentState',
        'TransactionNo',
        'ReservationStatus',
        'ExtraServices',
        'ReservationRemarks',
        'PayReceiptNo',
        'ParentReservationId',
        
    ];
}
