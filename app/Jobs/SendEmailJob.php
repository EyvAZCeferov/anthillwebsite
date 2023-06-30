<?php

namespace App\Jobs;

use App\Helpers\Helper;
use App\Mail\GeneralMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $data=null;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data=$data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
            $data=$this->data;
            return Mail::send(new GeneralMail($data['type'], $data['title'], $data['message'], $data['email'], $data['name_surname']));
        }catch(\Exception $e){
            \Log::info(['sendemailjoberror',$e->getMessage()]);
        }
    }
}
