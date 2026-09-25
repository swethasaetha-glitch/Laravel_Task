<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FabricRelaxation extends Model
{
    use HasFactory;

    protected $fillable = [
        'relaxation_no',
        'fabric_roll_id',
        'start_time',
        'end_time',
        'required_hours',
        'shrinkage_pct',
        'status',
    ];

    public function fabricRoll()
    {
        return $this->belongsTo(FabricRoll::class);
    }
}
