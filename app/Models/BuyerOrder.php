<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyerOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'buyer_name',
        'po_number',
        'order_date',
        'delivery_date',
        'total_garment_qty',
        'status',
    ];

    public function salesOrders()
    {
        return $this->hasMany(SalesOrder::class);
    }
}
