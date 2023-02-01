<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarDamage extends Model
{
    use HasFactory;
    protected $fillable = [
        'cars_id',
        'customer_id',
        'DamageCode',
        'DamageLevel',
        'DamageTitle',
        'DamageDescription',
        'DamageFiles',
        'DamagePrice',
        'DamageMaterials',
        'DamageMaintenanceStatus',
    ];
}
