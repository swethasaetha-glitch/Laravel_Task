<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionBundle extends Model
{
    use HasFactory;

    protected $fillable = [
        'bundle_no',
        'buyer',
        'style_no',
        'order_no',
        'garment',
        'color',
        'size',
        'total_qty',
        'completed_qty',
        'rejected_qty',
        'status',
    ];
}
