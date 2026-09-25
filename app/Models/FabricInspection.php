<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FabricInspection extends Model
{
    use HasFactory;

    protected $fillable = [
        'inspection_no',
        'fabric_roll_id',
        'inspected_length',
        'total_penalty_points',
        'points_per_100_sq_yds',
        'grade',
        'inspector_name',
        'status',
        'notes',
    ];

    public function fabricRoll()
    {
        return $this->belongsTo(FabricRoll::class);
    }
}
