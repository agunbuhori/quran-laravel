<?php

namespace App\Console\Commands;

use App\Models\AyahTranslation;
use App\Models\Surah;
use App\Models\Translator;
use Database\Seeders\Traits\HasQuranComApi;
use Illuminate\Console\Command;

class FetchAyahTranslationsFromQuranCom extends Command
{
    use HasQuranComApi;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quran:fetch-translations {translatorSource} {translatorTarget}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!Translator::where('id', $this->argument('translatorTarget'))->exists()) {
            $this->error('Translator source not found.');

            return;
        }

        $this->info('Fetching ayah translations from quran.com...');

        Surah::all()->each(function (Surah $surah) {
            $this->info("Fetching ayah translations for surah {$surah->id}...");

            $response = $this->getAyahsData($surah->id, $this->argument('translatorSource'));

            $translations = [];

            foreach ($response['verses'] as $verse) {
                array_push($translations, [
                    'ayah_id'       => $verse['id'],
                    'translator_id' => $this->argument('translatorTarget'),
                    'translation'   => $verse['translations'][0]['text'],
                ]);
            }

            AyahTranslation::insert($translations);
        });
    }
}
