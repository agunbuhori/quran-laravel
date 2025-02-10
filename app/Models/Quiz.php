<?php

namespace App\Models;

use App\Jobs\DeleteAudienceQuizContent;
use App\Models\Traits\HasRouteKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    /** @use HasFactory<\Database\Factories\QuizFactory> */
    use HasFactory, HasRouteKey;

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            dispatch(new DeleteAudienceQuizContent());
        });
        
        static::updated(function ($model) {
            dispatch(new DeleteAudienceQuizContent());
        });
        
        static::deleted(function ($model) {
            dispatch(new DeleteAudienceQuizContent());
        });
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'quiz_questions');
    }
}
