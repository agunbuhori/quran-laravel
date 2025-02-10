<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class RefreshTelegramWebhook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:refresh';

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
        $telegramToken = env("TELEGRAM_TOKEN");
        $telegramWebhookKey = Str::random(32);
        
        Cache::put("telegram_webhook_key", $telegramWebhookKey);

        $webhookUrl = "https://quran.buhori.com/api/telegram/webhook?key=$telegramWebhookKey";

        try {
            Http::post("https://api.telegram.org/bot$telegramToken/deleteWebhook");
            Http::post("https://api.telegram.org/bot$telegramToken/setWebhook?url=$webhookUrl");
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }

        $this->info($webhookUrl);
    }
}
