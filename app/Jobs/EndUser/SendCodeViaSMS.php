<?php

namespace App\Jobs\EndUser;

use App\Service\SMS\NetGSM;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Exception;

class SendCodeViaSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $recipient;
    protected string $message;

    /**
     * Create a new job instance.
     */
    public function __construct(string $recipient, string $message)
    {
        $this->recipient = $recipient;
        $this->message = $message;
    }

    /**
     * Execute the job.
     */
    public function handle(NetGSM $net_gsm_ervice): void
    {
        Log::info('SMS Request:', ['recipient' => $this->recipient, 'message' => $this->message]);
        try {
            $response = $net_gsm_ervice->sendToOne($this->recipient, $this->message);
            Log::info('SMS Response:', ['response' => $response]);
        } catch (Exception $e) {
            Log::error('SMS Sending Failed:', ['error' => $e->getMessage()]);
        }
    }
}
