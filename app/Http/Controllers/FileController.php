<?php

namespace App\Http\Controllers;

use App\Models\AyahReadLog;
use App\Models\YoutubeWatchLog;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    private $storage;

    public function __construct()
    {
        $this->storage = Storage::disk('ctb');
    }

    public function tafseer(int $surah, int $ayah)
    {
        $log = AyahReadLog::create([
            "surah" => $surah,
            "ayah" => $ayah,
            "ip_address" => request()->header('X-Real-Ip'),
            "is_audio_played" => false
        ]);

        return $this->resolveFile("tafsir/{$surah}_$ayah.mp3", $log);
    }

    public function play_tafseer(string $logId)
    {
        AyahReadLog::find($logId)->update(['is_audio_played' => true]);

        return responder()->success(["message" => "media is played"])->respond(200);
    }

    public function youtube(string $id)
    {
        $log = YoutubeWatchLog::create([
            "id" => $id,
            "ip_address" => request()->header('X-Real-Ip'),
            "is_audio_played" => false
        ]);

        return $this->resolveFile("youtube/$id.mp3", $log);
    }

    public function play_youtube(string $logId)
    {
        YoutubeWatchLog::find($logId)->update(['is_audio_played' => true]);

        return responder()->success(["message" => "media is played"])->respond(200);
    }

    private function resolveFile(string $path, $log)
    {
        if (! $this->storage->exists($path)) {
            return responder()->error(400, "File not found")->respond(400);
        }

        $expiryAt = now()->addDay();

        return responder()->success(['url' => Cache::remember($path, $expiryAt, fn () => $this->storage->temporaryUrl($path, $expiryAt)), 'log_id' => $log->id])->respond();
    }
}
