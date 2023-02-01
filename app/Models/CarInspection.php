<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarInspection extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'cars_id',
        'StartDate',
        'EndDate',
        'Status',
        'Cost',
        'Not',
        'Files',
    ];
}
