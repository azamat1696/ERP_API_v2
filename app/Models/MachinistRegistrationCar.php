<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachinistRegistrationCar extends Model
{
    use HasFactory;
    protected $fillable = [
        "car_damage_id",
        "registration_id"
    ];
    protected static function boot()
    {
        parent::boot();
        static::retrieved(function($model){
            $model->damage = $model->damage ?? 'applicant_' . $model->damage;
        });
    }

    public function damage() {
        return $this->belongsTo(CarDamage::class,'car_damage_id','id');
    }
  
}
