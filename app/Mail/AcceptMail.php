<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class AcceptMail extends Mailable
{
    use Queueable, SerializesModels;
    public $mailMessage;  // Renamed from $message

    /**
     * Create a new message instance.
     */
    public function __construct($mailMessage)
    {
        $this->mailMessage = $mailMessage;  // Update variable name
    }

    /**
     * Get the message content definition.
     */
    public function build()
    {
        return $this->view('email.accept') // Specify the email view
                    ->with([
                        'mailMessage' => $this->mailMessage,  // Update the data key
                    ]);
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
