<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageElements extends Model
{
    use HasFactory;
    protected $table='message_elements';
    protected $fillable=[
        'message_group_id',
        'message',
        'status',
    ];
    protected $casts=[
        'message_group_id'=>"integer",
        'status'=>'boolean'
    ];
    public function group(){
        return $this->hasOne(MessageGroups::class,'id','message_group_id');
    }
    
}
