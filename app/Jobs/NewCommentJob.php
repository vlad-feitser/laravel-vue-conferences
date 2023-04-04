<?php

namespace App\Jobs;

use App\Mail\NewCommentMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NewCommentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $firstname;
    public $lastname;
    public $conference;
    public $urlConference;
    public $lecture;
    public $urlLecture;
    public $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($firstname, $lastname, $conference, $urlConference, $lecture, $urlLecture, $email)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->conference = $conference;
        $this->urlConference = $urlConference;
        $this->lecture = $lecture;
        $this->urlLecture = $urlLecture;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)
            ->send(new NewCommentMail(
                $this->firstname,
                $this->lastname,
                $this->conference,
                $this->urlConference,
                $this->lecture,
                $this->urlLecture
            ));
    }
}
