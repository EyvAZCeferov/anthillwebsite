<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteUsers extends Model
{
    use HasFactory;
    protected $table='site_users';
    protected $fillable = [
        'ipaddress',
        'devicedata',
        'address_data'
    ];
    protected $casts=[
        'devicedata'=>"json",
        'address_data'=>"json"
    ];
    public function urls(){
        return $this->hasMany(SiteUsersUrls::class,'user_id','id');
    }
    public function viewcounts(){
        return $this->hasMany(ViewCounters::class,'site_user_id','id');
    }
}
