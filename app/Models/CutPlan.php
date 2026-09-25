<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CutPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'cut_plan_no',
        'sales_order_id',
        'fabric_id',
        'cad_type',
        'unit_of_measure',
        'no_of_piles',
        'size_breakup',
        'order_qty',
        'extra_qty',
        'cut_plan_type',
        'group_allocation',
        'status',
    ];

    protected $casts = [
        'size_breakup' => 'array',
    ];

    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class);
    }

    public function fabric()
    {
        return $this->belongsTo(Fabric::class);
    }

    public function lotBundles()
    {
        return $this->hasMany(LotBundle::class);
    }
}
