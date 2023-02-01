<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarSeyruSefer extends Model
{
    use HasFactory;
        protected $fillable=[
        'cars_id',
        'StartDateTime',
        'EndDateTime',
        'SeyruseferPrice',
        'Note',
        'Status',
        'InvoiceFile'
    ];
}
