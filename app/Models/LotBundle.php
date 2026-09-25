<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotBundle extends Model
{
    use HasFactory;

    protected $fillable = [
        'bundle_no',
        'qr_code_hash',
        'cut_plan_id',
        'lay_slip_id',
        'style_id',
        'size',
        'shade_group',
        'garment_qty',
        'operator_id',
        'supervisor_id',
        'machine_id',
        'stage',
    ];

    public function cutPlan()
    {
        return $this->belongsTo(CutPlan::class);
    }

    public function laySlip()
    {
        return $this->belongsTo(LaySlip::class);
    }

    public function style()
    {
        return $this->belongsTo(Style::class);
    }

    public function operator()
    {
        return $this->belongsTo(Operator::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class);
    }

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }

    public function scans()
    {
        return $this->hasMany(SewingMachineScan::class);
    }

    public function laundryRecords()
    {
        return $this->hasMany(LaundryRecord::class);
    }

    public function qualityAudits()
    {
        return $this->hasMany(QualityDashboardAudit::class);
    }
}
