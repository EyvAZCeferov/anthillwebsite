<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StandartPages extends Model
{
    use HasFactory;
    protected $table = 'standart_pages';
    protected $fillable = [
        'name',
        'slugs',
        'description',
        'type',
        'image'
    ];
    protected $casts = [
        'name'=>"json",
        'slugs'=>"json",
        'description'=>"json",
    ];
    public function seo(){
        return $this->hasOne(MetaSEO::class,'element_id','id')->where('type','standartpages')->orderBy('id','DESC');
    }
}
