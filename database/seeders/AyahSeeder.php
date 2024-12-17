<?php

namespace Database\Seeders;

use App\Models\Ayah;
use App\Models\Kalimah;
use App\Models\Surah;
use Database\Seeders\Traits\HasQuranComApi;
use Illuminate\Database\Seeder;

class AyahSeeder extends Seeder
{
    use HasQuranComApi;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Surah::get()->each(function ($surah) {
            $response = $this->getAyahsData($surah->id);

            $ayahs = [];
            $kalimahs = [];

            foreach ($response['verses'] as $verse) {
                array_push($ayahs, [
                    'surah_id'             => $surah->id,
                    'ayah_number'          => $verse['verse_number'],
                    'hizb_number'          => $verse['hizb_number'],
                    'rub_el_hizb_number'   => $verse['rub_el_hizb_number'],
                    'ruku_number'          => $verse['ruku_number'],
                    'manzil_number'        => $verse['manzil_number'],
                    'sajdah_number'        => $verse['sajdah_number'],
                    'page_number'          => $verse['page_number'],
                    'juz_number'           => $verse['juz_number'],
                    'text_uthmani'         => $verse['text_uthmani'],
                    'text_uthmani_simple'  => $verse['text_uthmani_simple'],
                    'text_uthmani_tajweed' => $verse['text_uthmani_tajweed'],
                    'text_indopak'         => $verse['text_indopak'],
                    'text_imlaei'          => $verse['text_imlaei'],
                    'text_imlaei_simple'   => $verse['text_imlaei_simple'],
                ]);

                array_push($kalimahs, $verse['words']);
            }

            $surah->ayahs()->insert($ayahs);

            $this->processKalimahs($kalimahs);
        });
    }

    private function processKalimahs(array $ayahKalimahs)
    {
        try {
            foreach ($ayahKalimahs as $ayahKalimah) {
                $kalimahs = [];
    
                foreach ($ayahKalimah as $kalimah) {
                    array_push($kalimahs, [
                        'ayah_id'          => $kalimah['verse_id'],
                        'position'         => $kalimah['position'],
                        'code_v1'          => $kalimah['code_v1'],
                        'code_v2'          => $kalimah['code_v2'],
                        'text_uthmani'     => $kalimah['text_uthmani'],
                        'qpc_uthmani_hafs' => $kalimah['qpc_uthmani_hafs'],
                        'transliteration'  => $kalimah['transliteration']['text'],
                    ]);
                }
    
                Kalimah::insert($kalimahs);
            }
        } catch (\Exception $e) {
            Ayah::truncate();

            throw $e;
        }
        
    }
}
