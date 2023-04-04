<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LectureDeleteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $conference;
    public $urlConference;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($conference, $urlConference)
    {
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
        return $this->view('emails.lecture_delete');
    }
}
