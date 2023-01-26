<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ApiController extends Controller
{
    function webhook(Request $request) {
        $replyToken = $request->input('events.0.replyToken');
        $messagType = $request->input('events.0.message.type');
        if($messagType != 'text') {
            return;
        }
        $text = $request->input('events.0.message.text');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('app.channel_access_token'),
        ])->post(config('app.line_endpoint_url_reply'), [
            'replyToken' => $replyToken,
            'messages' => [[
                'type' => 'text',
                'text' => $text
            ]],
        ]);
    }
}
