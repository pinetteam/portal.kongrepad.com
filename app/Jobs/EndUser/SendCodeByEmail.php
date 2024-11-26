<?php

namespace App\Jobs\EndUser;

use App\Mail\EndUser\SendCode;
use App\Models\Meeting\Participant\Participant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Mail;

class SendCodeByEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected Participant $recipient;

    /**
     * Create a new job instance.
     */
    public function __construct(Participant $recipient)
    {
        $this->recipient = $recipient;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('E-mail Request:', ['recipient' => $this->recipient]);
        try {
            Mail::to($this->recipient->email)->send(new SendCode($this->recipient));
            Log::info('E-mail sent!');
        } catch (Exception $e) {
            Log::error('E-mail Sending Failed:', ['error' => $e->getMessage()]);
        }
    }
}
