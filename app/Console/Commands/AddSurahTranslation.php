<?php

namespace App\Console\Commands;

use App\Models\SurahTranslation;
use Illuminate\Console\Command;

class AddSurahTranslation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quran:add-surah-translation';

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
        $surahNames = [];

        foreach ($surahNames as $id => $name) {
            $this->info("Adding translation for surah {$id}...");

            array_push($surahNames, [
                'surah_id' => $id,
                'lang' => 'th',
                'name' => $name,
            ]);
        }

        SurahTranslation::insert($surahNames);
    }
}
