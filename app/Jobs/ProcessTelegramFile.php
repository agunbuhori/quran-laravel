<?php

namespace App\Jobs;

use App\Models\TelegramChatBotRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProcessTelegramFile implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private TelegramChatBotRequest $chatBot)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $telegramToken = env("TELEGRAM_TOKEN");

        $files = [];

        if (array_key_exists('photo', $this->chatBot->message)) {
            $files = $this->chatBot->message['photo'];
        } else if (array_key_exists('document', $this->chatBot->message)) {
            $files = [$this->chatBot->message['document']];
        } else if (array_key_exists('audio', $this->chatBot->message)) {
            $files = [$this->chatBot->message['audio']];
        }  else if (array_key_exists('video', $this->chatBot->message)) {
            $files = [$this->chatBot->message['video']];
        } 
        
        try {
            $savedFiles = [];

            foreach ($files as $file) {
                $fileRequest = Http::post("https://api.telegram.org/bot$telegramToken/getFile", [
                    'file_id' => $file['file_id']
                ]);

                if ($fileRequest->successful()) {
                    $filePath = $fileRequest->json()['result']['file_path'];
                    $fileUrl = "https://api.telegram.org/file/bot$telegramToken/$filePath";
                    $fileContent = Http::get($fileUrl);
                    $fileName = basename($filePath); 
                    $fileTargetPath = "telegram/{$file['file_id']}_$fileName";

                    $saved = Storage::disk('ctb')->put($fileTargetPath, $fileContent->body());
                    $saved && $savedFiles[] = $fileTargetPath;
                }
            } 

            count($savedFiles) > 0 && $this->chatBot->update(['saved_files' => $savedFiles]);
        } catch (\Throwable $th) {
            Log::info("error when downloading instagram file", [$th->getMessage()]);
        }

    }
}
