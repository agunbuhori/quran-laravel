<?php

namespace App\Console\Commands;

use App\Models\Learn;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchYoutubeData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youtube:fetch {id}';

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
        $apiKey = env('YT_API_KEY');
        
        try {
            $youtube_id = $this->argument('id');

            $request = Http::get("https://www.googleapis.com/youtube/v3/videos?id=$youtube_id&part=snippet,contentDetails,statistics&key=$apiKey");

            if (isset($request['kind']) && $request['kind'] == 'youtube#videoListResponse') {
                $items = $request['items'];

                if (count($items)) {
                    $item = $items[0];

                    Learn::where('youtube_id', $item['id'])->update([
                        'thumbnail' => $item['snippet']['thumbnails']['medium']['url']
                    ]);
                }
            }
        } catch (\Throwable $th) {
            Log::error('error', [$th]);
        }
    }
}
