<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Style extends Model
{
    use HasFactory;

    protected $fillable = [
        'style_no',
        'style_name',
        'buyer_order_id',
        'garment_type',
        'sam',
        'description',
        'status',
    ];

    public function buyerOrder()
    {
        return $this->belongsTo(BuyerOrder::class);
    }

    public function processSequences()
    {
        return $this->hasMany(ProcessSequence::class)->orderBy('sequence_order');
    }

    public function lotBundles()
    {
        return $this->hasMany(LotBundle::class);
    }
}
