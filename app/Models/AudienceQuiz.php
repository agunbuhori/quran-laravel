<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class AudienceQuiz extends Model
{
    protected $connection = 'mongodb';
    protected $guarded = [];
}
