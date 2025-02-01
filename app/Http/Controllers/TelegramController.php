<?php

namespace App\Http\Controllers;

use App\Http\Requests\TelegramWebhookRequest;
use App\Jobs\GetTelegramFileJob;
use App\Jobs\ProcessTelegramChatBotJob;
use App\Jobs\SendTelegramJob;
use App\Models\TelegramChatBotRequest;
use Illuminate\Support\Facades\Log;

class TelegramController extends Controller
{
    public function index()
    {
        return responder()->success(TelegramChatBotRequest::simplePaginate(100));
    }

    public function webhook(TelegramWebhookRequest $request)
    {
        $chatBot = TelegramChatBotRequest::create([
            'chat_id' => $request->message['chat']['id'],
            'text' => $request->message['text'] ?? null,
            'photo' => $request->message['photo'] ?? null
        ]);

        dispatch(new GetTelegramFileJob($chatBot));

        return true;
    }
}
