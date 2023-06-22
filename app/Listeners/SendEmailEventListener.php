<?php

namespace App\Listeners;

use App\Helpers\Helper;
use App\Mail\GeneralMail;
use App\Events\SendEmailEvent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailEventListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(SendEmailEvent $event)
    {
        try{
            $event=$event->datas;
            return Mail::send(new GeneralMail($event['type'], $event['title'], $event['message'], $event['email'], $event['name_surname']));
        }catch(\Exception $e){
            \Log::info(['sendemailjoberror',$e->getMessage()]);
        }
    }
}
