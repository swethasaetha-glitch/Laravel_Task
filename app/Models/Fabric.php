<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fabric extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'fabric_code',
        'fabric_name',
        'fabric_type',
        'composition',
        'color',
        'gsm',
        'width',
        'unit',
        'description',
        'status',
    ];

    public function groups()
    {
        return $this->belongsToMany(FabricGroup::class, 'fabric_group_fabric');
    }

    public function layModels()
    {
        return $this->hasMany(LayModel::class);
    }
}
