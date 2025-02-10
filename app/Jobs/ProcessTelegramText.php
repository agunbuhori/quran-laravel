<?php

namespace App\Jobs;

use App\Models\TelegramChatBotRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessTelegramText implements ShouldQueue
{
    use Queueable;

    private string $prompt;

    /**
     * Create a new job instance.
     */
    public function __construct(private TelegramChatBotRequest $chatBot)
    {
        preg_match('/^\/[a-z]+$/', $chatBot->message['text'] ?? "", $matches);

        if (count($matches)) {
            $this->prompt = $matches[0];
        }
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (! isset($this->chatBot->message['text'])) {
            return;
        }

        switch ($this->prompt) {
            case "/start":
                dispatch(new SendTelegramJob($this->chatBot['message']['chat']['id'], "Yow whatsupp!"));
                break;
        }
        
    }
}
