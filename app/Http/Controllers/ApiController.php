<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    function webhook(Request $request) {
        $replyToken = $request->input('events.0.replyToken');
        $messagType = $request->input('events.0.message.type');
        if($messagType != 'text') {
            return;
        }
        $text = $request->input('events.0.message.text');

        Http::withHeaders([
            'Authorization' => 'Bearer ' . config('app.channel_access_token'),
        ])->post('https://api.line.me/v2/bot/message/reply', [
            'replyToken' => $replyToken,
            'messages' => [[
                'type' => 'text',
                'text' => $text
            ]],
        ]);
    }
}
