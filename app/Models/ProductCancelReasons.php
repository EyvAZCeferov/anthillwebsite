<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCancelReasons extends Model
{
    use HasFactory;
    protected $table = 'product_cancel_reasons';
    protected $fillable = [
        'product_id',
        'reason',
        'status'
    ];
    protected $casts = [
        'product_id'=>"integer",
        "reason"=>"json",
        'status'=>"boolean",
    ];
    public function product(){
        return $this->belongsTo(Products::class);
    }
}
