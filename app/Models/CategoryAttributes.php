<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryAttributes extends Model
{
    use HasFactory;
    protected $table = 'category_attributes';
    protected $fillable = [
        'category_id',
        'attribute_group_id',
    ];

    protected $casts = [
        'category_id'=>"integer",
        'attribute_group_id'=>"integer",
    ];
    public function category(){
        return $this->belongsTo(Categories::class);
    }
    public function attribute_group(){
        return $this->belongsTo(Attributes::class)->orderBy('order_att','ASC');
    }
}
