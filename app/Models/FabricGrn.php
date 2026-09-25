<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FabricGrn extends Model
{
    use HasFactory;

    protected $fillable = [
        'grn_no',
        'fabric_po_id',
        'supplier_invoice_no',
        'received_date',
        'total_rolls_received',
        'received_qty',
        'status',
    ];

    public function fabricPo()
    {
        return $this->belongsTo(FabricPo::class);
    }

    public function rolls()
    {
        return $this->hasMany(FabricRoll::class);
    }
}
