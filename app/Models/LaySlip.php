<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaySlip extends Model
{
    use HasFactory;

    protected $fillable = [
        'lay_slip_no',
        'production_plan_id',
        'lay_model_id',
        'fabric_group_id',
        'table_no',
        'spreader_operator',
        'total_plies',
        'lay_length',
        'marker_efficiency_pct',
        'status',
        'notes',
    ];

    public function productionPlan()
    {
        return $this->belongsTo(ProductionPlan::class);
    }

    public function layModel()
    {
        return $this->belongsTo(LayModel::class);
    }

    public function fabricGroup()
    {
        return $this->belongsTo(FabricGroup::class);
    }
}
