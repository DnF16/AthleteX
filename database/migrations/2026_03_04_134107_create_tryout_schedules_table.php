<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TryoutScheduleMail extends Mailable
{
    use Queueable, SerializesModels;

    public $athlete;
    public $schedule;

    // We pass the athlete info and schedule info into the email
    public function __construct($athlete, $schedule)
    {
        $this->athlete = $athlete;
        $this->schedule = $schedule;
    }

    public function build()
    {
        $sportName = str_replace('_', ' ', $this->schedule->sport_event);
        
        return $this->subject('Your Tryout Schedule: ' . $sportName . ' - SDO')
                    ->view('emails.tryout_schedule'); // This points to the blade file we will make next
    }
}