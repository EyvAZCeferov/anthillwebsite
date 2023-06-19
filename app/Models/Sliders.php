<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sliders extends Model
{
    use HasFactory;
    protected $table='sliders';
    protected $fillable=[
        'image',
        'description',
        'url',
        'order'
    ];
    protected $casts=[
        'description'=>'json',
        'order'=>'integer'
    ];
}
