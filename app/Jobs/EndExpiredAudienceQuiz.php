<?php

namespace App\Jobs;

use App\Models\AudienceQuiz;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class EndExpiredAudienceQuiz implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        AudienceQuiz::whereNotNull('result.started_at')->whereNull('result.ended_at')->chunkById(1000, function ($audienceQuizzes) {
            foreach ($audienceQuizzes as $audienceQuiz) {
                if (Carbon::parse($audienceQuiz->result['started_at'])->addMinutes($audienceQuiz->duration) <= now()) {
                    $audienceQuiz->update([
                        '$set' => [
                            'result.ended_at' => now()   
                        ]
                    ]);
                    dispatch(new CalculateAudienceQuizScore($audienceQuiz));
                }
            }
        });
    }
}
