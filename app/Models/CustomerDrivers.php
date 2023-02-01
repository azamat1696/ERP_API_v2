<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerDrivers extends Model
{
    use HasFactory;
    protected $fillable = [
      'customer_id',
      'DriverName',  
      'DriverSurname',  
      'DriverPhone',  
      'DriverEmail',  
      'Status',  
    ];
    protected static function boot()
    {
        parent::boot();
        static::retrieved(function($model){
            $model->document = $model->document ?? 'applicant_' . $model->document;
        });
    }
    public function document() {
        return $this->hasOne(CustomerDocument::class);
    }
}
