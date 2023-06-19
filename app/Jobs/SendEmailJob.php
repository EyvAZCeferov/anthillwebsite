<?php

namespace App\Jobs;

use App\Mail\GeneralMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $message, $tomail, $toname, $type, $subject;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $message, $tomail, $toname, $type, $subject)
    {
        // $this->product = $product;
        $this->message = $message;
        $this->tomail = $tomail;
        $this->toname = $toname;
        $this->type = $type;
        $this->subject=$subject;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // return Mail::send(new GeneralMail($this->type, $this->subject, $this->message, $this->tomail, $this->toname));  
    }
}
