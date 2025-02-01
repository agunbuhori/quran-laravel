<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class YoutubeWatchLog extends Model
{
    protected $connection = 'mongodb';
    protected $fillable = ['id', 'ip_address', 'is_audio_played'];
}
