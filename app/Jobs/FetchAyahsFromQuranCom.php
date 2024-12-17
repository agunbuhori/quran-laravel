<?php

namespace App\Jobs;

use App\Models\Surah;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;

class FetchAyahsFromQuranCom implements ShouldQueue
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
        Surah::get()->each(function ($surah) {
            $response = Http::get("https://api.qurancdn.com/api/qdc/verses/by_chapter/{$surah->id}", [
                'words' => true,
                'translation_fields' => 'resource_name,language_id',
                'per_page' => 286,
                'fields' => 'text_indopak,chapter_id,hizb_number,text_imlaei_simple,text_uthmani,text_imlaei,text_madani,text_uthmani_tajweed',
                'translations' => 39,
                'reciter' => 7,
                'word_translation_language' => 'en',
                'page' => 1,
                'word_fields' => 'verse_key,verse_id,page_number,location,text_uthmani,code_v1,qpc_uthmani_hafs,code_v2',
                'mushaf' => 1,
            ]);

            

            foreach ($response['verses'] as $verse) {
                $surah->ayahs()->insert([
                    'surah_id'             => $surah->id,
                    'ayah_number'          => $verse['verse_number'],
                    'hizb_number'          => $verse['hizb_number'],
                    'rub_el_hizb_number'   => $verse['rub_el_hizb_number'],
                    'ruku_number'          => $verse['ruku_number'],
                    'manzil_number'        => $verse['manzil_number'],
                    'sajdah_number'        => $verse['sajdah_number'],
                    'page_number'          => $verse['page_number'],
                    'juz_number'           => $verse['juz_number'],
                    'text_uthmani_simple'  => $verse['text_uthmani'],
                    'text_uthmani_tajweed' => $verse['text_uthmani_tajweed'],
                    'text_indopak'         => $verse['text_indopak'],
                    'text_imlaei'          => $verse['text_imlaei'],
                ]);
            }
        });
    }
}
