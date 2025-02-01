<?php

namespace App\Http\Transformers;

use App\Models\Learn;
use Flugg\Responder\Transformers\Transformer;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class LearnIndexTransformer extends Transformer
{
    public function transform(Learn $learn)
    {
        return [
            'id'             => $learn->getSecretKey(),
            'title'          => $learn->title,
            'type'           => $learn->type,
            'thumbnail'      => $this->getThumbnail($learn),
            'link'           => $learn->link ? $this->rememberLink("learn_link:{$learn->id}", $learn->link) : null,
            'youtube_id'     => $learn->youtube_id,
            'playlist_count' => $learn->learns()->count(),
            'created_at'     => $learn->created_at
        ];
    }

    private function getThumbnail($learn)
    {
        if ($learn->youtube_id) {
            return "https://i.ytimg.com/vi/{$learn->youtube_id}/default.jpg";
        }

        return $learn->thumbnail ? $this->rememberLink("learn_thumbnail:{$learn->id}", $learn->thumbnail) : null;
    }

    private function rememberLink(string $key, string $value)
    {
        if (str_contains($value, "https://")) {
            return $value;
        }

        return Cache::remember($key, 86400, fn () => Storage::disk('ctb')->temporaryUrl($value, now()->addDay()));
    }
}