<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsAttributes extends Model
{
    use HasFactory;
    protected $table = 'products_attributes';
    protected $fillable = [
        'product_id',
        'attribute_group_id',
        'attribute_id',
    ];
    protected $casts = [
        'product_id' => 'integer',
        'attribute_id' => 'integer',
        'attribute_group_id' => 'integer',
    ];

    public function attribute()
    {
        return $this->hasOne(Attributes::class,'id','attribute_id');
    }
    public function attributegroup()
    {
        return $this->hasOne(Attributes::class,'id','attribute_group_id');
    }
}
