<?php

namespace App\Jobs;

use App\Mail\LectureDeleteMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class LectureDeleteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $conference;
    public $urlConference;
    public $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($conference, $urlConference, $email)
    {
        $this->conference = $conference;
        $this->urlConference = $urlConference;
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
            ->send(new LectureDeleteMail($this->conference, $this->urlConference));
    }
}
