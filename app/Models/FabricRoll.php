<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FabricRoll extends Model
{
    use HasFactory;

    protected $fillable = [
        'roll_no',
        'fabric_grn_id',
        'fabric_id',
        'gross_weight',
        'net_weight',
        'width',
        'shade',
        'bin_location',
        'inspection_status',
        'relaxation_status',
    ];

    public function fabricGrn()
    {
        return $this->belongsTo(FabricGrn::class);
    }

    public function fabric()
    {
        return $this->belongsTo(Fabric::class);
    }

    public function inspection()
    {
        return $this->hasOne(FabricInspection::class);
    }

    public function relaxation()
    {
        return $this->hasOne(FabricRelaxation::class);
    }
}
