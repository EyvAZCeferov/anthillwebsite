<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Products extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'products';
    protected $fillable = [
        'uid',
        'name',
        'address',
        'contactinfo',
        'code',
        'description',
        'category_id',
        'slugs',
        'status',
        'price',
        'user_id',
        "token"
    ];
    protected $casts = [
        'name' => 'json',
        'address' => 'json',
        'description' => 'json',
        'contactinfo' => 'json',
        'category_id' => 'integer',
        'slugs' => 'json',
        'status' => 'integer',
        'user_id'=>"integer"
    ];

    public function attributes()
    {
        return $this->hasMany(ProductsAttributes::class, 'product_id', 'id')->with('attribute')->orderBy('order_att');
    }
    public function seo()
    {
        return $this->hasOne(MetaSEO::class, 'element_id', 'id')->where("type","products");
    }
    public function category()
    {
        return $this->belongsTo(Categories::class);
    }
    public function cancelreason(){
        return $this->hasOne(ProductCancelReasons::class,'product_id','id')->where('status',true);
    }
    public function user(){
        return $this->belongsTo(User::class)->with("additionalinfo");
    }
    public function images(){
        return $this->hasMany(ProductEncodedImages::class,'product_id','id')->orderBy('order_a',"ASC");
    }
    public function comments(){
        return $this->hasMany(Comments::class,'product_id','id');
    }
    public function viewcount(){
        return $this->hasMany(ViewCounters::class,'element_id','id')->where('type','product');
    }
}
