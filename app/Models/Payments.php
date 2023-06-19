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
        "price",
        "to_id",
        "from_id",
    ];
    protected $casts = [
        'amount' => 'float',
        'payment_status' => 'integer',
        'data' => 'json',
        'frompayment' => 'json', 
        "price"=>"float",
        "to_id"=>"integer",
        "from_id"=>"integer",
    ];
    public function from(){
        return $this->hasOne(User::class,'from_id','id');
    }
    public function touser(){
        return $this->hasOne(User::class,'to_id','id');
    }
}
