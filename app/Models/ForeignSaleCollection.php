<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForeignSaleCollection extends Model
{
    use HasFactory;
    protected $fillable = [
        'foreign_sale_id',
        'ReceiptCollectionNo',
        'MessageContent',
    ];
}
