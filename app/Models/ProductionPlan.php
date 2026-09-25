<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_no',
        'sales_order_id',
        'planned_start_date',
        'planned_end_date',
        'target_daily_qty',
        'line_allocation',
        'status',
    ];

    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class);
    }

    public function laySlips()
    {
        return $this->hasMany(LaySlip::class);
    }
}
