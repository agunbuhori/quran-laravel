<?php

namespace App\Jobs;

use App\Models\Surah;
use Elasticsearch\ClientBuilder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ExportAyahsToElasticSearch implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private Surah $surah)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $client = ClientBuilder::create()->build();

            foreach ($this->surah->ayahs as $ayah) {
                $data = [
                    'body'  => $ayah->toArray(),
                    'index' => 'ayahs',
                    'type'  => 'ayah',
                    'id'    => $ayah->id,
                ];
    
                $client->index($data);
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
        }
    }
}
