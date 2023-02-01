<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForeignSale extends Model
{
    use HasFactory;
    protected $fillable = [
        'InvoiceNo',
        'InvoiceTitle',
        'UnitPrice',
        'Piece',
        'VatRate',
        'UnitTotal',
        'SubTotal',
        'VatTotal',
        'Total',
        'TotalSting',
        'Description',
    ];
//    protected static function boot()
//    {
//        parent::boot();
//        static::retrieved(function($model){
//            $model->collection = $model->collection ?? 'applicant_' . $model->collection;
//        });
//    }
    public function collection() {
        return $this->hasOne(ForeignSaleCollection::class);
    }
}
