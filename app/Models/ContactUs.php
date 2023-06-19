<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;

    protected $table = 'contact_us';
    protected $fillable = [
        'subject',
        'message',
        'name',
        'email',
        'phone',
        'ipadress',
        'user_id',
        'product_id',
    ];
    protected $casts = [
        'user_id'=>"integer",
        'product_id'=>"integer",
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function product(){
        return $this->belongsTo(Products::class);
    }
}
