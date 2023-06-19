<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetaSEO extends Model
{
    use HasFactory;
    protected $table = 'meta_seo';
    protected $fillable = [
        'name',
        'description',
        'keywords',
        'type',
        'element_id'
    ];
    protected $casts = [
        'name' => 'json',
        'description' => 'json',
        'keywords' => 'json',
        'element_id' => 'integer'
    ];
}
