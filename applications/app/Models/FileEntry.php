<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class FileEntry extends Model
{
    use HasUuids;

    protected $fillable = [
        'original_name',
        'server_path',
        'slug',
        'password',
        'is_one_time',
        'expires_at',
    ];

    protected $casts = [
        'is_one_time' => 'boolean',
        'expires_at' => 'datetime',
    ];
}
