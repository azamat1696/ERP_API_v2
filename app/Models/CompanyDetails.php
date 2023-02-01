<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyDetails extends Model
{
    use HasFactory;
    protected $primaryKey = null;
    public $incrementing = false;
    protected $fillable = [
        'CompanyID',
        'AuthorizedName',
        'AuthorizedSurname',
        'AuthorizedEmail',
        'AuthorizedPhone',
        'CompanyName',
        'CompanyEmail',
        'CompanyPhone',
        'CompanyAddress',
        'CompanyLogo',
        'CompanyVatNumber',
        'CompanyWebSite',
        'CompanyBusinessArea',
        'CompanyAccessToken',
        'CompanyStatus'

    ];
}
