<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaundryRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'wash_batch_no',
        'lot_bundle_id',
        'wash_type',
        'status',
        'received_at',
        'completed_at',
    ];

    protected $casts = [
        'received_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function lotBundle()
    {
        return $this->belongsTo(LotBundle::class);
    }
}
