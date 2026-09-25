<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'sales_order_no',
        'buyer_order_id',
        'style_no',
        'garment_type',
        'colorway',
        'size_ratio',
        'order_qty',
        'status',
    ];

    public function buyerOrder()
    {
        return $this->belongsTo(BuyerOrder::class);
    }

    public function productionPlan()
    {
        return $this->hasOne(ProductionPlan::class);
    }

    public function fabricPos()
    {
        return $this->hasMany(FabricPo::class);
    }
}
