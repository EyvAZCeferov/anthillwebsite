<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WishlistItems extends Model
{
    use HasFactory;
    protected $table='wishlist_items';
    protected $fillable=[
        'user_id',
        'product_id',
        'ipaddress'
    ];
    protected $casts=[
        'user_id'=>'integer',
        'product_id'=>'integer'
    ];
    public function user():BelongsTo{
        return $this->belongsTo(User::class,'id','user_id');
    }
    public function product():BelongsTo{
        return $this->belongsTo(Products::class,'id','product_id');
    }
}
