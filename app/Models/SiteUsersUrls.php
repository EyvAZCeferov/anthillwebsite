<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteUsersUrls extends Model
{
    use HasFactory;
    protected $table='site_users_urls';
    protected $fillable=[
        'user_id',
        'url',
        'previous_url'
    ];
    public function user(){
        return $this->belongsTo(SiteUsers::class);
    }
}
