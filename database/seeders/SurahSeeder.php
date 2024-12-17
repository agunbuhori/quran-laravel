<?php

namespace Database\Seeders;

use App\Models\Surah;
use App\Models\SurahTranslation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class SurahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $response = Http::get('https://api.quran.com/api/v4/chapters?language=id');

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

            SurahTranslation::insert([
                'surah_id' => $chapter['id'],
                'lang'     => 'id',
                'name'     => $chapter['translated_name']['name'],
            ]);
        }

        $response = Http::get('https://api.quran.com/api/v4/chapters?language=ms');

        foreach ($response->json()['chapters'] as $chapter) {
            SurahTranslation::insert([
                'surah_id' => $chapter['id'],
                'lang'     => 'ms',
                'name'     => $chapter['translated_name']['name'],
            ]);
        }
        
        $response = Http::get('https://api.quran.com/api/v4/chapters?language=en');

        foreach ($response->json()['chapters'] as $chapter) {
            SurahTranslation::insert([
                'surah_id' => $chapter['id'],
                'lang'     => 'en',
                'name'     => $chapter['translated_name']['name'],
            ]);
        }

    }
}
