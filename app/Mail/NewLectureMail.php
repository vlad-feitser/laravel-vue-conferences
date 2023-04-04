<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewLectureMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $conference;
    public $urlConference;
    public $lecture;
    public $urlLecture;
    public $start_time;
    public $end_time;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $conference, $urlConference, $lecture, $urlLecture, $start_time, $end_time)
    {
        $this->name = $name;
        $this->conference = $conference;
        $this->urlConference = $urlConference;
        $this->lecture = $lecture;
        $this->urlLecture = $urlLecture;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.new_lecture');
    }
}
