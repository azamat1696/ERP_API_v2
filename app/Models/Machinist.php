<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machinist extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'machinist_type_id',
        'CompanyName',
        'CompanyPhone',
        'CompanyEmail',
        'AuthorizedPerson',
        'CompanyTaxAddress',
        'CompanyTaxNumber',
        'CompanyAddress',
        'Status'
    ];
}
