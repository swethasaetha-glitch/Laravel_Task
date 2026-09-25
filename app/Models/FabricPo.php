<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FabricPo extends Model
{
    use HasFactory;

    protected $fillable = [
        'po_no',
        'sales_order_id',
        'fabric_id',
        'supplier_name',
        'required_qty',
        'unit',
        'delivery_date',
        'status',
    ];

    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class);
    }

    public function fabric()
    {
        return $this->belongsTo(Fabric::class);
    }

    public function grns()
    {
        return $this->hasMany(FabricGrn::class);
    }
}
