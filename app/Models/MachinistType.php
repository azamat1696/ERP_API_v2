<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachinistType extends Model
{
    use HasFactory;
    protected $fillable = [
        'TypeName',
        'Status'
    ];
}
