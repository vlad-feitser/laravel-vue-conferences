<?php

namespace App\Jobs;

use App\Mail\ConferenceDeleteMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ConferenceDeleteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $conference;
    public $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($conference, $email)
    {
        $this->conference = $conference;
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
            ->send(new ConferenceDeleteMail($this->conference));
    }
}
