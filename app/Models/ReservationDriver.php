<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationDriver extends Model
{
    use HasFactory;
    protected $fillable = [
        'reservation_id',
        'driver_id',
        'Status'
    ];
    
    public function driverCustomer()
    {
        return $this->belongsTo(Customer::class,'driver_id')->with('avaliableDocument');
    }
 
}
