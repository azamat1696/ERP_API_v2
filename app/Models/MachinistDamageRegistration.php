<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachinistDamageRegistration extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'cars_id',
        'machinist_id',
        'ReservationStartDate',
        'ReservationEndDate',
        'EstimatedRepairCost',
        'Description',
        'EstimatedRepairCost',
        'ReservationStatus',
    ];
    
    public function carDamages() {
        return $this->hasMany(MachinistRegistrationCar::class,'registration_id');
    }
    public function car(){
        return $this->belongsTo(Cars::class,'cars_id' );
    }
}
