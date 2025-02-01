<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class AyahReadLog extends Model
{
    protected $connection = 'mongodb';
    protected $fillable = ['surah', 'ayah', 'ip_address', 'is_audio_played'];
}
