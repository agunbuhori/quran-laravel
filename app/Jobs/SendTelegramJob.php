<?php

namespace App\Jobs;

use App\Models\TelegramChatBotResponse;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendTelegramJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private string $chatId, private string $text)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $telegramToken = env("TELEGRAM_TOKEN");
        
        try {
            Http::post("https://api.telegram.org/bot$telegramToken/sendMessage", [
                'chat_id' => $this->chatId,
                'text' => $this->text
            ]);

            TelegramChatBotResponse::create([
                'chat_id' => $this->chatId,
                'text' => $this->text
            ]);
        } catch (\Throwable $th) {
            Log::error("telegram sending error", [$th->getMessage()]);
        }
    }
}
