<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExternalSyncLog extends Model
{
    protected $fillable = [
        'source',
        'status',
        'summary',
        'payload_json',
    ];

    protected function casts(): array
    {
        return [
            'payload_json' => 'array',
        ];
    }
}
