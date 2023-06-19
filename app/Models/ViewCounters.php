<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewCounters extends Model
{
    use HasFactory;
    protected $table = 'view_counters';
    protected $fillable = [
        'element_id',
        'site_user_id',
        'user_id',
        'type'
    ];
    protected $casts = [
        'element_id'=>"integer",
        'site_user_id'=>"integer",
        'user_id'=>"integer",
    ];
    public function siteuser(){
        return $this->belongsTo(SiteUsers::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
