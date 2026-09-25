<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LayModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'lay_model_code',
        'lay_model_name',
        'fabric_group_id',
        'fabric_id',
        'lay_length',
        'lay_width',
        'number_of_plies',
        'garment_size',
        'marker_length',
        'marker_width',
        'description',
        'status',
    ];

    public function fabricGroup()
    {
        return $this->belongsTo(FabricGroup::class);
    }

    public function fabric()
    {
        return $this->belongsTo(Fabric::class);
    }
}
