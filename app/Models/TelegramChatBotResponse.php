<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class TelegramChatBotResponse extends Model
{
    protected $fillable = ['chat_id', 'text'];
}
