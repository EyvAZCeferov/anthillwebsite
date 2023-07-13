<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WishlistItems extends Model
{
    use HasFactory;
    protected $table = 'wishlist_items';
    protected $fillable = [
        'user_id',
        'product_id',
        'ipaddress'
    ];
    protected $casts = [
        'user_id' => 'integer',
        'product_id' => 'integer'
    ];
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function product(): HasOne
    {
        return $this->hasOne(Products::class, 'product_id', 'id');
    }
}
