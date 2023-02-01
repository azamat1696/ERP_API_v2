<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerUnit extends Model
{
    use HasFactory;
    protected $fillable = [
        'Name',
        'Description',
        'Status'
    ];
}
