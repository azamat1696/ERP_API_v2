<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiptCollection extends Model
{
    use HasFactory;
    protected $fillable = [
      'invoice_id',  
      'reservation_id',  
      'ReceiptCollectionNo',  
      'MessageContent',  
  
    ];
}
