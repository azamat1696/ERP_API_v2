<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarInsurance extends Model
{
    use HasFactory;
    protected $table = 'car_insurance';
    protected $fillable = [
        'cars_id',
        'StartDateTime',
        'EndDateTime',
        'InsurancePrice',
        'Note',
        'Status',
        'InvoiceFile',
        'Type'
    ];
}
