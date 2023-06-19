<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaElements extends Model
{
    use HasFactory;
    protected $table = 'mediaelements';
    protected $fillable = [
        'name',
        'description',
        'category_id',
        'slugs',
        'pdf',
        'image',
        'background_image',
        'icon',
        'type',
        'color',
        'owner_name',
        'times',
        'register_active'
    ];
    protected $casts = [
        'name' => 'json',
        'description' => 'json',
        'category_id' => 'integer',
        'slugs' => 'json',
        'times' => 'json',
        'type'=>"integer",
        'register_active'=>"boolean"
    ];

    public function category(){
        return $this->belongsTo(Categories::class);
    }

    public function seo(){
        return $this->hasOne(MetaSEO::class,'element_id','id')->where('type','mediaelements');
    }

    public function additional_images(){
        return $this->hasMany(AdditionalPictures::class,'element_id','id')->where('type','mediaelements');
    }
    public function views(){
        return $this->hasMany(ViewCounters::class,'element_id','id')->where('type','mediaelements');
    }
}
