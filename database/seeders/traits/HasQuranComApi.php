<?php

namespace Database\Seeders\Traits;

use Illuminate\Support\Facades\Http;

trait HasQuranComApi
{
    public function getAyahsData(int $surahId, int $translations = 39, $word_translation_language = 'id')
    {
        return Http::get("https://api.qurancdn.com/api/qdc/verses/by_chapter/{$surahId}", [
            'words'                     => true,
            'translation_fields'        => 'resource_name,language_id',
            'per_page'                  => 286,
            'fields'                    => 'text_uthmani,text_uthmani_simple,text_imlaei,text_imlaei_simple,text_indopak,text_uthmani_tajweed',
            'translations'              => $translations,
            'reciter'                   => 7,
            'word_translation_language' => $word_translation_language,
            'page'                      => 1,
            'word_fields'               => 'verse_key,verse_id,page_number,location,text_uthmani,code_v1,qpc_uthmani_hafs,code_v2',
            'mushaf'                    => 1,
        ]);
    }
}