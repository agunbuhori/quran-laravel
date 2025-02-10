<?php

namespace App\Jobs;

use Illuminate\Support\Arr;
use App\Models\AudienceQuiz;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class CalculateAudienceQuizScore implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private AudienceQuiz $audienceQuiz)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $questions = $this->audienceQuiz->questions;
    

        $score = 0;
        $correctAnswers = 0;
        $wrongAnswers = 0;
        $notAnswered = 0;
        $totalScore = 0;

        foreach ($questions as $question) {
            
            if ($question['selected'] === null) {
                $totalScore += $question['correct_weight'];
                $notAnswered++;
                continue;
            }

            $corrects = array_filter($question['answers'], fn ($answer) => $answer['correct']);
            $wrongs = array_filter($question['answers'], fn ($answer) => !$answer['correct']);

            $correctScore = count(array_intersect(array_column($corrects, 'id'), $question['selected'])) * $question['correct_weight'];
            $wrongScore = count(array_intersect(array_column($wrongs, 'id'), $question['selected'])) * $question['wrong_weight'];

            $totalScore += count($corrects) * $question['correct_weight'];

            $score += $correctScore + $wrongScore;
        }

        $this->audienceQuiz->update([
            '$set' => [
                'result.score'           => $score ? round(($score / $totalScore) * 100, 1) : 0.0,
                'result.correct_answers' => $correctAnswers,
                'result.wrong_answers'   => $wrongAnswers,
                'result.not_answered'    => $notAnswered
            ]
        ]);
    }
}
