<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;
    protected $table = 'payments';
    protected $fillable = [
        'amount',
        'transaction_id',
        'payment_status',
        'data',
        'frompayment',
        'from_id',
        'to_id'
    ];
    protected $casts = [
        'amount' => 'float',
        'payment_status' => 'integer',
        'data' => 'json',
        'frompayment' => 'json',
    ];
    public function from()
    {
        return $this->hasOne(User::class,'from_id','id')->where('is_admin', false);
    }
    public function touser()
    {
        return $this->belongsTo(User::class,'to_id','id')->where('is_admin', false);
    }
    public function product()
    {
        return $this->belongsTo(Products::class);
    }
}
