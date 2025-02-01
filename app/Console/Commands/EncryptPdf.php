<?php

namespace App\Console\Commands;

use App\Models\Learn;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class EncryptPdf extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'file:encrypt-pdf';

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
        Learn::whereNotNull('link')->where('type', 'ebook')->chunk(1000, function ($learns) {
            foreach ($learns as $learn) {
                $output = Artisan::call("file:encrypt {$learn->link}");
                $this->info($output);
            }
        });
    }
}
