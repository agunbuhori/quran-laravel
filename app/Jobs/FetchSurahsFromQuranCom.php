<?php

namespace App\Jobs;

use App\Models\Surah;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;

class FetchSurahsFromQuranCom implements ShouldQueue
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
        $response = Http::get('https://api.quran.com/api/v4/chapters');

        foreach ($response->json()['chapters'] as $chapter) {
            Surah::insert([
                'id'               => $chapter['id'],
                'revelation_place' => $chapter['revelation_place'],
                'revelation_order' => $chapter['revelation_order'],
                'bismillah_pre'    => $chapter['bismillah_pre'],
                'name_simple'      => $chapter['name_simple'],
                'name_complex'     => $chapter['name_complex'],
                'name_arabic'      => $chapter['name_arabic'],
                'ayahs_count'      => $chapter['verses_count'],
                'pages'            => json_encode($chapter['pages']),
            ]);
        }
    }
}
