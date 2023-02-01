<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarBrand extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'BrandName',
        'BrandLogo',
        'Status',
        'created_at',
        'updated_at'
    ];
    public function user_id() {
        return $this->hasOne(User::class);
    }
}
