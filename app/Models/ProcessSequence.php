<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessSequence extends Model
{
    use HasFactory;

    protected $fillable = [
        'style_id',
        'sequence_order',
        'process_name',
        'department',
        'sam',
    ];

    public function style()
    {
        return $this->belongsTo(Style::class);
    }
}
