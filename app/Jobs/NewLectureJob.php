<?php

namespace App\Jobs;

use App\Mail\NewLectureMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class NewLectureJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $name;
    public $conference;
    public $urlConference;
    public $lecture;
    public $urlLecture;
    public $start_time;
    public $end_time;
    public $email;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($name, $conference, $urlConference, $lecture, $urlLecture, $start_time, $end_time, $email)
    {
        $this->name = $name;
        $this->conference = $conference;
        $this->urlConference = $urlConference;
        $this->lecture = $lecture;
        $this->urlLecture = $urlLecture;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
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
            ->send(new NewLectureMail(
                $this->name,
                $this->conference,
                $this->urlConference,
                $this->lecture,
                $this->urlLecture,
                $this->start_time,
                $this->end_time
            ));
    }
}
