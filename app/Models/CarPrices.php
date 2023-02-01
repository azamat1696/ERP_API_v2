<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarPrices extends Model
{
    use HasFactory;
    protected $fillable =[
        'model_id',
        'DailyPrice',
        'WeeklyPrice',
        'MonthlyPrice',
        'YearlyPrice',
        'WeeklyPriceRange',
        'MonthlyPriceRange',
        'YearlyPriceRange'
    ];
}
