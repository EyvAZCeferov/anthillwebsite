<?php
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Auth;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat.{roomid}', function ($user,$roomid) {
    // return Auth::check();
    if(Auth::check()){
        return ['id'=>$user->id,'name'=>$user->name_surname];
    }
});

Broadcast::channel('emailjob.{element}', function ($user) {
    return true;
});
