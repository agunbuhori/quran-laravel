<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class TelegramChatBotRequest extends Model
{
    protected $connection = 'mongodb';
    protected $fillable = ['chat_id', 'text', 'photo'];
}
