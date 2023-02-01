<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarSeasonsPrice extends Model
{
    use HasFactory;
    protected $fillable = [
        'SeasonName',
        'StartDate',
        'EndDate',
        'Percentage',
        'Status'
    ];
}
