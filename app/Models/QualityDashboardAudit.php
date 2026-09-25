<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualityDashboardAudit extends Model
{
    use HasFactory;

    protected $fillable = [
        'lot_bundle_id',
        'garment_defect_id',
        'operator_id',
        'machine_id',
        'department',
        'defect_count',
        'audit_result',
        'remarks',
    ];

    public function lotBundle()
    {
        return $this->belongsTo(LotBundle::class);
    }

    public function garmentDefect()
    {
        return $this->belongsTo(GarmentDefect::class);
    }

    public function operator()
    {
        return $this->belongsTo(Operator::class);
    }

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }
}
