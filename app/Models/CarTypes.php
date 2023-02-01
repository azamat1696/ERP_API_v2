<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarTypes extends Model
{
    protected $table = 'car_body_types';
    use HasFactory;
    protected $fillable = [
      'user_id',
      'TypeName',
      'Status'
    ];
}
