<?php

namespace App\Listeners;

use App\Events\NewChatMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\MessageElements;
use App\Models\MessageGroups;
class SendChatMessageNotification
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(MessageElements $messageelement)
    {
        
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\NewChatMessage  $event
     * @return void
     */
    public function handle(NewChatMessage $event)
    {
        //
    }
}
