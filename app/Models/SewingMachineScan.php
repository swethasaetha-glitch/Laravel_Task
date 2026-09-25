<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SewingMachineScan extends Model
{
    use HasFactory;

    protected $fillable = [
        'lot_bundle_id',
        'machine_id',
        'operator_id',
        'department',
        'scan_type',
        'scanned_at',
    ];

    protected $casts = [
        'scanned_at' => 'datetime',
    ];

    public function lotBundle()
    {
        return $this->belongsTo(LotBundle::class);
    }

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }

    public function operator()
    {
        return $this->belongsTo(Operator::class);
    }
}
