<?php

namespace App\Http\Controllers;

use App\Services\MessageApiClient;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    function webhook(Request $request, MessageApiClient $messageApiClient) {
        $messagType = $request->input('events.0.message.type');
        if($messagType == 'text') {
            $replyToken = $request->input('events.0.replyToken');
            $text = $request->input('events.0.message.text');
            $messageApiClient->sendReplyTextMessage($replyToken, $text);
        }
        return response()->json([]);
    }
}
