<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ForwardDocumentsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $filename;

    /**
     * Create a new message instance.
     */
    public function __construct($filenameInput)
    {
        $this->filename = $filenameInput;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Forward Documents Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function build(){
        $pathToFile = Storage::disk('public')->path('files/' . $this->filename);
    
        return $this->view('forwardDocuments')
                    ->attach($pathToFile, [
                        'as' => $this->filename,
                        'mime' => 'application/pdf',
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
