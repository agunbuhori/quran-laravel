<?php

namespace App\Jobs;

use App\Models\Organizer;
use App\Models\TelegramChatBotRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;

class ProcessTelegramChatBotJob implements ShouldQueue
{
    use Queueable;

    private string $cacheKey;
    /**
     * Create a new job instance.
     */
    public function __construct(private TelegramChatBotRequest $telegramChatBotRequest)
    {
        $this->cacheKey = "chat_{$this->telegramChatBotRequest->chat_id}";
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        switch ($this->sanitizedPrompt()) {
            case "/daftar":
                $this->handleStart();
                break;
            case "/kajian";
                $this->handleKajian();
                break;
            default:
                $this->handleAll();
        }
    }

    private function sanitizedPrompt(): string
    {
        preg_match('/^\/[a-z]+/', $this->telegramChatBotRequest->text, $result);

        return count($result) > 0 ? $result[0] : "none";
    }

    private function handleStart()
    {
        Cache::put($this->cacheKey, "registration", now()->addHour());

        dispatch(new SendTelegramJob($this->telegramChatBotRequest->chat_id, "Ahlan wa sahlan, silakan sebutkan nama organizer antum:"));
    }

    private function handleAll()
    {
        switch (Cache::get($this->cacheKey)) {
            case "registration":
                $organizer = Organizer::create([
                    'name' => $this->telegramChatBotRequest->text
                ]);

                dispatch(new SendTelegramJob($this->telegramChatBotRequest->chat_id, "Selamat, organizer atas nama {$organizer->name} berhasil didaftarkan. Buat jadwal kajian dengan cara mengirim /kajian."));
                
                break;
            case "kajian":
                dispatch(new SendTelegramJob($this->telegramChatBotRequest->chat_id, "Judul disimpan, kirim gambar poster disini:"));

                Cache::put($this->cacheKey, "poster", now()->addHour());

                break;
            case "poster":
                dispatch(new SendTelegramJob($this->telegramChatBotRequest->chat_id, "Poster disimpan, tulis nama masjid atau majelis tempat kajian:"));

                Cache::put($this->cacheKey, "mosque", now()->addHour());
            case "mosque":
                dispatch(new SendTelegramJob($this->telegramChatBotRequest->chat_id, "Tulis alamat majelis atau masjid tempat kajian:"));

                Cache::put($this->cacheKey, "address", now()->addHour());
            case "address":
                dispatch(new SendTelegramJob($this->telegramChatBotRequest->chat_id, "Poster disimpan, tulis nama masjid atau majelis tempat kajian:"));

                Cache::put($this->cacheKey, "mosque", now()->addHour());


        }
    }
    
    private function handleKajian()
    {
        Cache::put($this->cacheKey, "kajian", now()->addHour());

        dispatch(new SendTelegramJob($this->telegramChatBotRequest->chat_id, "Masukkan judul kajian:"));
    }

}
