<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FabricGroup extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'group_code',
        'group_name',
        'description',
        'status',
    ];

    public function fabrics()
    {
        return $this->belongsToMany(Fabric::class, 'fabric_group_fabric');
    }

    public function layModels()
    {
        return $this->hasMany(LayModel::class);
    }
}
