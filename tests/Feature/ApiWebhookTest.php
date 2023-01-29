<?php

namespace Tests\Feature;

use App\Services\MessageApiClient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery\MockInterface;
use Tests\TestCase;

class ApiWebhookTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_root_returns_404()
    {
        $response = $this->get('/');
        $response->assertStatus(404);
    }

    public function test_reply_message_is_sent()
    {
        $mock = $this->mock(MessageApiClient::class, function(MockInterface $mock) {
            $mock->shouldReceive('sendReplyTextMessage')->once()->with('dummy-reply-token', 'test message');
        });

        $inMessage = [
            'destination' => '',
            'events' => [[
                'type' => 'message',
                'message' => ['type' => 'text', 'id' => '1', 'text' => 'test message'],
                'webhookEventId' => '',
                'deliveryContext' => ['isRedelivery' => 'false'],
                'timestamp' => 0,
                'source' => ['type' => 'user', 'userId' => 'dummy-user-id'],
                'replyToken' => 'dummy-reply-token',
                'mode' => 'active'
            ]]
        ];

        $response = $this->postJson('/api/webhook', $inMessage);
        $response->assertStatus(200);
        $response->assertExactJson([]);
    }

    public function test_reply_message_not_sent_for_nontext_message()
    {
        $mock = $this->mock(MessageApiClient::class, function(MockInterface $mock) {
            $mock->shouldNotReceive('sendReplyTextMessage');
        });

        $inMessage = [
            'destination' => '',
            'events' => [[
                'type' => 'message',
                'message' => ['type' => 'image', 'id' => '1', 'contentProvider' => ['type', 'line']],
                'webhookEventId' => '',
                'deliveryContext' => ['isRedelivery' => 'false'],
                'timestamp' => 0,
                'source' => ['type' => 'user', 'userId' => 'dummy-user-id'],
                'replyToken' => 'dummy-reply-token',
                'mode' => 'active'
            ]]
        ];

        $response = $this->postJson('/api/webhook', $inMessage);
        $response->assertStatus(200);
        $response->assertExactJson([]);
    }


}
