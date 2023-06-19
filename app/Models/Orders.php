<?php

namespace App\Models;

use App\Models\Products;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Orders extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = [
        'uid',
        'from_id',
        'to_id',
        'product_id',
        'payment_id',
        'status',
        'price',
        'ipaddress',
    ];
    protected $casts = [
        'from_id' => 'integer',
        'to_id' => 'integer',
        'product_id' => 'integer',
        'payment_id' => 'integer',
        'status' => 'integer',
        'price' => "float",
    ];

    public function from(){
        return $this->hasOne(User::class,'id','from_id');
    }
    public function touser(){
        return $this->hasOne(User::class,'id','to_id');
    }
    public function product()
    {
        return $this->hasOne(Products::class, 'product_id', 'id')->withTrashed();
    }
    public function payment()
    {
        return $this->belongsTo(Payments::class, 'payment_id', 'id');
    }
}
