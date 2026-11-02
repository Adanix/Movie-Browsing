<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Language extends Model
{
    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'code',
        'name',
        'native_name',
    ];

    public function movies(): HasMany
    {
        return $this->hasMany(Movie::class, 'audio_language_code', 'code');
    }
}
