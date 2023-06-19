<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attributes extends Model
{
    use HasFactory;
    protected $table = 'attributes';
    protected $fillable = [
        'name',
        'slugs',
        'group_id',
        'datatype',
        'order_att'
    ];

    protected $casts = [
        'name' => 'json',
        'slugs' => 'json',
        'group_id'=>'integer',
        'order_att'=>"integer",
    ];

    public function group(){
        return $this->belongsTo(Attributes::class);
    }

    public function groupElements(){
        return $this->hasMany(Attributes::class,'group_id','id');
    }
    
}
