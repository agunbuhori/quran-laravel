<?php

namespace App\Http\Controllers;

use App\Http\Requests\TelegramWebhookRequest;
use App\Jobs\ProcessTelegramFile;
use App\Jobs\ProcessTelegramText;
use App\Models\TelegramChatBotRequest;

class TelegramController extends Controller
{
    public function index()
    {
        request()->validate([
            'per_page' => ['max:30', 'min:1']
        ]);

        return responder()->success(TelegramChatBotRequest::orderBy('created_at', 'desc')->simplePaginate(request()->get('per_page', 15)));
    }

    /**
     * Webhook
     * 
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder
     */
    public function webhook(TelegramWebhookRequest $request)
    {
        $chatBot = TelegramChatBotRequest::create($request->only('update_id', 'message'));

        if (isset($request->message['text'])) {
            dispatch(new ProcessTelegramText($chatBot));
        }
        
        foreach (['photo', 'document', 'audio', 'video'] as $file) {
            if (isset($request->message[$file])) {
                dispatch(new ProcessTelegramFile($chatBot));
            }
        }

        return responder()->success(['message' => 'everything is okay']);
    }
}
