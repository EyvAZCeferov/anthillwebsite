<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $fillable = [
        'name',
        'slugs',
        'image',
        'icon',
        'top_id',
        "status",
        'color',
    ];
    protected $casts = [
        'name' => 'json',
        'slugs' => 'json',
        'view' => 'integer',
        'top_id' => 'integer',
        'status' => "boolean",
    ];

    public function seo()
    {
        return $this->hasOne(MetaSEO::class, 'element_id', 'id')->where('type', 'category');
    }

    public function top_category()
    {
        return $this->hasOne(Categories::class, 'id', 'top_id');
    }
    public function alt_categoryes()
    {
        return $this->hasMany($this, 'top_id');;
    }
    
    public function products(){
        return $this->hasMany(Products::class,'category_id','id');
    }
    public function attributes(){
        return $this->hasMany(CategoryAttributes::class,'category_id','id');
    }
}
