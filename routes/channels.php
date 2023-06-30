<?php
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat.{roomId}', function ($user, $roomId) {
    if(Auth::check()){
        return ['id' => $user->id, 'user' => $user->name_surname];
    }else{
        \Log::info("user not found");
    }
});

Broadcast::channel('chats',function($user){
    if(Auth::check()){
        return ['id' => $user->id, 'user' => $user->name_surname];
    }else{
        \Log::info("user not found");
    }
});

Broadcast::channel('emailjob.{element}', function ($user) {
    return true;
});
