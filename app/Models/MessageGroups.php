<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageGroups extends Model
{
    use HasFactory;
    protected $table='message_groups';
    protected $fillable=[
        'receiver_id',
        'sender_id',
        'product_id',
    ];
    protected $casts=[
        'receiver_id'=>"integer",
        'sender_id'=>"integer",
        'product_id'=>"integer"
    ];
    public function receiverinfo(){
        return $this->hasOne(User::class,'id','receiver_id')->with('additionalinfo');
    }
    public function senderinfo(){
        return $this->hasOne(User::class,'id','sender_id')->with('additionalinfo');
    }
    public function message_elements(){
        return $this->hasMany(MessageElements::class,'message_group_id','id')->orderBy('status','ASC')->orderBy('created_at','DESC');
    }
    public function product(){
        return $this->hasMany(Products::class,'product_id','id')->orderBy('id','DESC')->orderBy('created_at','DESC');
    }
}
