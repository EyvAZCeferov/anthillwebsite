<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;
    protected $table='comments';
    protected $fillable=[
        'product_id',
        'user_id',
        'rating',
        'comment',
        'status',
    ];
    protected $casts=[
        'product_id'=>"integer",
        'rating'=>"integer",
        'status'=>"boolean",
    ];
    public function product(){
        return $this->belongsTo(Products::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
