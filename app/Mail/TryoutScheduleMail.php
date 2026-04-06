<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TryoutScheduleMail extends Mailable
{
    use Queueable, SerializesModels;

    public $athlete;
    public $schedule;

    /**
     * Create a new message instance.
     */
    public function __construct($athlete, $schedule)
    {
        $this->athlete = $athlete;
        $this->schedule = $schedule;
    }

    /**
     * Get the message envelope (The Subject Line).
     */
    public function envelope(): Envelope
    {
        $sportName = str_replace('_', ' ', $this->schedule->sport_event);
        
        return new Envelope(
            subject: 'Your Tryout Schedule: ' . $sportName . ' - SDO',
        );
    }

    /**
     * Get the message content definition (The HTML template).
     */
    public function content(): Content
    {
        return new Content(
            view: 'features.email_tryout', // <-- Now it points to your features folder!
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}