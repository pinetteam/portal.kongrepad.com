<?php

namespace App\Jobs\EndUser;

use App\Http\Controllers\Service\SMS\NetGSM\NetGSMSMSController;
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

    protected $recipient;
    protected $message;

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
    public function handle(NetGSMSMSController $net_gsm_ervice): void
    {
        Log::info('SMS Request:', ['recipient' => $this->recipient, 'message' => $this->message]);
        try {
            $response = $net_gsm_ervice->sendSms($this->recipient, $this->message);
            Log::info('SMS Response:', ['response' => $response]);
        } catch (Exception $e) {
            Log::error('SMS Sending Failed:', ['error' => $e->getMessage()]);
        }
    }
}
