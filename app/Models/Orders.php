<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    protected $table='orders';
    protected $fillable=[
        'uid',
        'from_id',
        'to_id',
        'product_id',
        'payment_id',
        'status',
        'price',
        'ipaddress',
    ];
    protected $casts=[
        'from_id'=>'integer',
        'to_id'=>'integer',
        'product_id'=>'integer',
        'payment_id'=>'integer',
        'status'=>'integer',
        'price'=>"float",
    ];

    public function from()
    {
        return $this->hasOne(User::class,'id','from_id')->where('is_admin', false);
    }
    public function touser()
    {
        return $this->hasOne(User::class,'id','to_id')->where('is_admin', false);
    }
    public function product()
    {
        return $this->belongsTo(Products::class)->withTrashed();
    }
    public function payment(){
        return $this->belongsTo(Payments::class);
    }

}
