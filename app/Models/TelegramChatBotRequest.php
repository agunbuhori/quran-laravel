<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class TelegramChatBotRequest extends Model
{
    protected $connection = 'mongodb';
    protected $guarded = ['key'];
}
