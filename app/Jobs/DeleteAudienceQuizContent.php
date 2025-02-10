<?php

namespace App\Jobs;

use App\Models\AudienceQuiz;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class DeleteAudienceQuizContent implements ShouldQueue
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
        AudienceQuiz::whereNull('result.started_at')->chunkById(1000, function ($audienceQuizzes) {
            foreach ($audienceQuizzes as $audienceQuiz) {
                $audienceQuiz->delete();
            }
        });
    }
}
