<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LangProperties extends Model
{
    use HasFactory;
    protected $table='lang_properties';
    protected $fillable=[
        'keyword',
        'lang',
        'name'
    ];
}
