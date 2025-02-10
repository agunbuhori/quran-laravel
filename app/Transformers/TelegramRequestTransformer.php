<?php

namespace App\Transformers;

use App\Models\TelegramChatBotRequest;
use App\Models\TelegramRequest;
use Flugg\Responder\Transformers\Transformer;

class TelegramRequestTransformer extends Transformer
{
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [];

    /**
     * List of autoloaded default relations.
     *
     * @var array
     */
    protected $load = [];

    /**
     * Transform the model.
     *
     * @return array
     */
    public function transform(TelegramChatBotRequest $telegramRequest)
    {
        return [
            'id' => $telegramRequest->id,
            'message' => [
                'date' => $telegramRequest->message['date'],
                'text' => $telegramRequest->message['text'] ?? null,
                'photo' => $telegramRequest->message['photo'] ?? null,
                'document' => $telegramRequest->message['document'] ?? null,
            ]
        ];
    }
}
