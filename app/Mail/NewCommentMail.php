<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewCommentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $firstname;
    public $lastname;
    public $conference;
    public $urlConference;
    public $lecture;
    public $urlLecture;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($firstname, $lastname, $conference, $urlConference, $lecture, $urlLecture)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->conference = $conference;
        $this->urlConference = $urlConference;
        $this->lecture = $lecture;
        $this->urlLecture = $urlLecture;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.new_comment');
    }
}
