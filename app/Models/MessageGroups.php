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
    ];
    protected $casts=[
        'receiver_id'=>"integer",
        'sender_id'=>"integer",
    ];
    public function receiver(){
        return $this->hasOne(User::class,'receiver_id','id');
    }
    public function sender(){
        return $this->hasOne(User::class,'sender_id','id');
    }
    public function message_elements(){
        return $this->hasMany(MessageElements::class,'message_group_id','id');
    }
}
