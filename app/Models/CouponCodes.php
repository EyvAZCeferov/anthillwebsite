<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponCodes extends Model
{
    use HasFactory;
    protected $table='coupon_codes';
    protected $fillable=[
        'name',
        'code',
        'value',
        'status',
        'oneusing',
        'type'
    ];
    protected $casts=[
        'name'=>"json",
        'status'=>"boolean",
        'oneusing'=>"boolean",
        'type'=>"integer",
        "value"=>"float",
    ];
}
