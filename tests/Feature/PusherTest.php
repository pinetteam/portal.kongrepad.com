<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Events\PusherTestEvent;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

class PusherTest extends TestCase
{
    /**
     * Test Pusher configuration is correct.
     *
     * @return void
     */
    public function test_pusher_config_exists()
    {
        $appId = Config::get('broadcasting.connections.pusher.app_id');
        $appKey = Config::get('broadcasting.connections.pusher.key');
        $appSecret = Config::get('broadcasting.connections.pusher.secret');
        $appCluster = Config::get('broadcasting.connections.pusher.options.cluster');

        $this->assertNotEmpty($appId, 'Pusher App ID bulunamadı. .env dosyasını kontrol edin.');
        $this->assertNotEmpty($appKey, 'Pusher App Key bulunamadı. .env dosyasını kontrol edin.');
        $this->assertNotEmpty($appSecret, 'Pusher App Secret bulunamadı. .env dosyasını kontrol edin.');
        $this->assertNotEmpty($appCluster, 'Pusher App Cluster bulunamadı. .env dosyasını kontrol edin.');
    }

    /**
     * Test broadcasting is set to pusher.
     *
     * @return void
     */
    public function test_broadcast_driver_is_pusher()
    {
        $broadcastDriver = Config::get('broadcasting.default');
        $this->assertEquals('pusher', $broadcastDriver, 'Broadcast driver pusher olarak ayarlanmamış.');
    }

    /**
     * Test event broadcasting.
     *
     * @return void
     */
    public function test_event_broadcasting()
    {
        Event::fake();
        
        // Event'i fırlatıyoruz
        PusherTestEvent::dispatch('Test mesajı');
        
        // Event'in fırlatıldığını kontrol ediyoruz
        Event::assertDispatched(PusherTestEvent::class, function ($event) {
            return $event->message === 'Test mesajı';
        });
    }
} 