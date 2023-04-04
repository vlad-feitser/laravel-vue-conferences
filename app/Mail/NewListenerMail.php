<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewListenerMail extends Mailable
{
    use Queueable, SerializesModels;

    public $firstname;
    public $lastname;
    public $conference;
    public $urlConference;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($firstname, $lastname, $conference, $urlConference)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->conference = $conference;
        $this->urlConference = $urlConference;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.new_listener');
    }
}
