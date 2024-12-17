<?php

namespace App\Jobs;

use App\Models\Surah;
use App\Models\SurahTranslation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;

class FetchSurahTranslationsFromQuranCom implements ShouldQueue
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
        $langs = ['en', 'id'];

        foreach ($langs as $lang) {
            $response = Http::get("https://api.quran.com/api/v4/chapters?language=$lang");

            foreach ($response['chapters'] as $chapter) {
                SurahTranslation::insert([
                    'surah_id' => $chapter['id'],
                    'lang'     => $lang,
                    'name'     => $chapter['translated_name']['name'],
                ]);
            }
        }
    }
}
