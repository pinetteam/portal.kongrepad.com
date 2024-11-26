<?php

namespace App\Mail\EndUser;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SendCode extends Mailable
{
    use Queueable, SerializesModels;

    private $recipient;

    /**
     * Create a new message instance.
     */
    public function __construct($recipient)
    {
        $this->recipient = $recipient;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('info@kongrepad.com', 'KongrePad'),
            subject: 'KongrePad için erişim kodunuz'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // QR kodu oluştur
        $qr_code_image = base64_encode(
            QrCode::size(256)->generate($this->recipient['username'])
        );

        return new Content(
            view: 'mails.end-user.send-code',
            with: [
                'recipient' => $this->recipient,
                'qr_code_image' => $qr_code_image,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
