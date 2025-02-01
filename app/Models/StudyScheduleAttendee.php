<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class StudyScheduleAttendee extends Model
{
    protected $connection = 'mongodb';
    protected $fillable = ['study_schedule_id', 'user_id'];
}
