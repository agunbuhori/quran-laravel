<?php

namespace App\Jobs;

use App\Models\TelegramChatBotRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GetTelegramFileJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private TelegramChatBotRequest $telegramChatBotRequest)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (! is_array($this->telegramChatBotRequest->photo)) {
            return;
        }

        $telegramToken = env("TELEGRAM_TOKEN");

        foreach ($this->telegramChatBotRequest->photo as $photo) {
            try {
                $file = Http::post("https://api.telegram.org/bot$telegramToken/getFile", [
                    'file_id' => $photo['file_id']
                ]);

                if ($file->successful()) {
                    $filePath = $file->json()['result']['file_path'];
                    $fileUrl = "https://api.telegram.org/file/bot{$telegramToken}/{$filePath}";
                    $fileContent = Http::get($fileUrl);
                    $fileName = basename($filePath); 

                    Storage::disk('ctb')->put("telegram/{$photo['file_id']}_$fileName", $fileContent->body());
                }
            } catch (\Throwable $th) {
                Log::info("error when downloading instagram photo", [$th->getMessage()]);
            }
        }

    }
}
