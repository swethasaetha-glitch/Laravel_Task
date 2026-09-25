<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TapperReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'tapper_no',
        'fabric_id',
        'roll_no',
        'before_shrinkage_len',
        'before_shrinkage_width',
        'after_shrinkage_len',
        'after_shrinkage_width',
        'shrinkage_percent',
        'shade_group',
        'arvind_approval_status',
        'allowance_value',
        'quality_notes',
    ];

    public function fabric()
    {
        return $this->belongsTo(Fabric::class);
    }
}
