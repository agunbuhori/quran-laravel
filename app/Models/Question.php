<?php

namespace App\Models;

use App\Jobs\DeleteAudienceQuizContent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /** @use HasFactory<\Database\Factories\QuestionFactory> */
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'answers' => 'json'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            self::sanitizeQuestionAnswers($model);
        });
        
        static::updating(function ($model) {
            self::sanitizeQuestionAnswers($model);
        });

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

    public function quizzes()
    {
        return $this->belongsToMany(Quiz::class, 'quiz_questions');
    }

    private static function sanitizeQuestionAnswers(Model $model)
    {
        $model->question = self::changeS3Link($model->question);

        $model->answers = collect($model->answers)->map(function ($answer) {
            $answer['answer'] = self::changeS3Link($answer['answer']);
            return $answer;
        });
            
    }

    private static function changeS3Link($currentLink)
    {
        $replacedLink = str_replace("https://sin1.contabostorage.com/bekalislam/", "https://sin1.contabostorage.com/41cf553ab1094b77a0e7bd2e2e6f979c:bekalislam/", $currentLink);

        $regex = '/<a[^>]*>(<img[^>]*>).*?<figcaption[^>]*>.*?<\/figcaption>.*?<\/a>/is';
        $replacedLink = preg_replace($regex, '$1', $replacedLink);

        return $replacedLink;
    }
}
