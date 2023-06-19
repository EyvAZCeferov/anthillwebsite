<?php

namespace App\Mail;

use App\Models\Settings;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GeneralMail extends Mailable
{
    use Queueable, SerializesModels;
    public $type, $subject, $messagecontent, $tomail = null, $toname = null;

    public function __construct($type, $subject, $messagecontent, $tomail = null, $toname = null)
    {
        $this->type = $type;
        $this->subject = $subject;
        $this->messagecontent = $messagecontent;
        $this->tomail = $tomail;
        $this->toname = $toname;
    }

    public function build()
    {
        $setting = Settings::latest()->first();

        if (!empty($this->tomail) && !empty($this->toname)) {
            return $this->from(env("MAIL_FROM_ADDRESS"), env("MAIL_FROM_NAME"))
                ->to($this->tomail ?? env("MAIL_FROM_ADDRESS"), $this->toname ?? env("MAIL_FROM_NAME"))
                ->subject($this->subject)
                ->view('emails.sendmessage', ['messagecontent' => $this->messagecontent, 'type' => $this->type, 'setting' => $setting,'subject'=>$this->subject]);
        } else {
            return $this->from(env("MAIL_FROM_ADDRESS"), env("MAIL_FROM_NAME"))
                ->to($this->tomail, $this->toname)
                ->subject($this->subject)
                ->view('emails.sendmessage', ['messagecontent' => $this->messagecontent, 'type' => $this->type, 'setting' => $setting,'subject'=>$this->subject]);
        }
    }
}
