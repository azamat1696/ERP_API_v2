<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cars extends Model
{
    use HasFactory;
    protected $fillable = [
        'EngineCapacity',
        'offices_id',
        'CarColor',
        'NumberOfSmallBags',
        'Status',
        'car_fuel_types_id',
        'LicencePlate',
        'NumberOfSeats',
        'Year',
        'CarTypeId',
        'NumberOfDoors',
        'Image',
        'NumberOfLargeBags',
        'CarAvailability',
        'car_transmission_types_id',
        'car_classes_id',
        'car_body_types_id',
        'car_models_id',
        'car_brands_id',
        'ExtraFields',
        'CarRemarks',
        'IsReserved',
    ];
    
 
}
