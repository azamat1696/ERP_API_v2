<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;
    protected $fillable = [
        'OfficeAddress' ,
        'OfficeContacts',
        'OfficeName',
        'OfficePhone',
        'OfficeEmail',
        'Positions',
        'OfficeWorkingPeriods',
        'cities_id',
        'districts_id',
        'Status'
    ];
    
    public function withCityName() {
        return $this->belongsTo(Cities::class,'cities_id');
    }
    public function DistrictName() {
        return $this->belongsTo(Districts::class,'districts_id')->select('DistrictName');
    }

    
}
