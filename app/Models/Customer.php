<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
class Customer extends Model
{
    use HasFactory,HasApiTokens;
    protected $fillable = [
         'districts_id',
         'cities_id',
         'customer_groups_id',
         'CustomerType',
         'CompanyName',
         'Name',
         'Surname',
         'Gender',
         'Email',
         'Phone',
         'Password',
         'DateOfBirthDate',
         'Address',
         'Status',
         'EmailVerifiedHash'
    ];
    public  function customerDocuments() 
    {
        return $this->hasMany(CustomerDocument::class);
    }
    public function reservationDrivers(){
        return $this->hasMany(CustomerDocument::class);
    }
    public function customerDrivers() {
        return $this->hasMany(CustomerDrivers::class);
    }

    public function scopeDetail($query)
    {
        return $query->with('customerDocuments', 'customerDrivers');
   }
   
   public function avaliableDocument() {
        
        return $this->hasOne(CustomerDocument::class)->where('Status',true)->where('DocumentTypeId',1);
   }
}
