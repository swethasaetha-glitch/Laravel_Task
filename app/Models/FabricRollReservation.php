<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FabricRollReservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_no',
        'fabric_roll_id',
        'requested_by_dept',
        'status',
        'storage_location',
    ];

    public function fabricRoll()
    {
        return $this->belongsTo(FabricRoll::class);
    }
}
