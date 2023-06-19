<?php

namespace App\Mail;

use App\Helpers\Helper;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GeneralMail extends Mailable
{
    use Queueable, SerializesModels;
    public $type, $subject, $messagecontent, $tomail, $toname;

    public function __construct($type, $subject, $messagecontent, $tomail, $toname)
    {
        $this->type = $type;
        $this->subject = $subject;
        $this->messagecontent = $messagecontent;
        $this->tomail = $tomail;
        $this->toname = $toname;
    }

    public function build()
    {
        try {
            $setting = setting();
            return $this->from(env("MAIL_FROM_ADDRESS"), env("MAIL_FROM_NAME"))
                ->to($this->tomail, $this->toname)
                ->subject($this->subject)
                ->view('emails.sendmessage', ['messagecontent' => $this->messagecontent, 'type' => $this->type, 'setting' => $setting, 'subject' => $this->subject]);
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
        }
    }
}
