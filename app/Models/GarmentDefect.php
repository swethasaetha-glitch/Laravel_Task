<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GarmentDefect extends Model
{
    use HasFactory;

    protected $fillable = [
        'defect_code',
        'defect_name',
        'category',
        'severity',
    ];
}
