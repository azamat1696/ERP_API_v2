<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerDocument extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'customer_drivers_id',
        'DocumentDateOfExpire',
        'DocumentDateOfIssue',
        'DocumentTypeId',
        'DocumentPath',
        'DocumentPath2',
        'DocumentNumber',
        'DocumentNotes',
        'Status',
    ];
}
