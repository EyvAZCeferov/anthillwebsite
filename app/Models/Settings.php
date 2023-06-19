<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;
    protected $table = 'settings';
    protected $fillable = [
        'title',
        'description',
        'address',
        'social_media',
        'logo',
        'open_hours',
    ];

    protected $casts = [
        'title' => "json",
        'description' => "json",
        'address' => "json",
        'social_media' => "json",
        'open_hours' => "json",
    ];
}
