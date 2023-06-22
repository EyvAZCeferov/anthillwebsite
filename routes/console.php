<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Broadcast;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Broadcast::channel('chat.{roomId}', function ($user, $roomId) {
//     return ['id' => $user->id, 'user' => $user->name_surname];
// });

// Broadcast::channel('emailjob.{element}', function ($user,$element) {
//     return $user;
// });
