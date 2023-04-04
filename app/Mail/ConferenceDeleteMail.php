<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConferenceDeleteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $conference;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($conference)
    {
        $this->conference = $conference;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.conference_delete');
    }
}
