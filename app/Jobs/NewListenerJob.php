<?php

namespace App\Jobs;

use App\Mail\NewListenerMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class NewListenerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $firstname;
    public $lastname;
    public $conference;
    public $urlConference;
    public $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($firstname, $lastname, $conference, $urlConference, $email)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
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
            ->send(new NewListenerMail(
                $this->firstname,
                $this->lastname,
                $this->conference,
                $this->urlConference
            ));
    }
}
