<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductEncodedImages extends Model
{
    use HasFactory;
    protected $table = 'product_encoded_images';
    protected $fillable = [
        'encoded_watermaker_images',
        'encoded_thumbnail_images',
        'original_images',
        'original_compressed_images',
        'product_id',
        "code",
        'order_a',
        "token"
    ];
    protected $casts = [
        'product_id'=>"integer",
        "code"=>"string",
        'order_a'=>"integer",
    ];
    public function product(){
        return $this->belongsTo(Products::class);
    }
}
