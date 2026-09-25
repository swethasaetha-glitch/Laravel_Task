<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    use HasFactory;

    protected $fillable = [
        'machine_no',
        'machine_name',
        'machine_type',
        'department',
        'line_no',
        'status',
    ];

    public function scans()
    {
        return $this->hasMany(SewingMachineScan::class);
    }
}
