<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackTechApp extends Model
{
    use HasFactory;

    protected $fillable = [
        'sno',
        'app_name',
        'package_name',
        'live_version',
        'test_version',
        'category',
        'route_name',
        'status',
    ];
}
