<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class UserAdditionals extends Model
{
    protected $table = 'user_additionals';
    protected $fillable = [
        'user_id',
        'company_name',
        'company_slugs',
        'company_address',
        'company_image',
        'company_description',
        'original_pass',
        'company_contact_infos',
    ];
    protected $casts = [
        'user_id'=>"integer",
        'company_name'=>"json",
        'company_slugs'=>"json",
        'company_address'=>"json",
        'company_description'=>"json",
        'company_contact_infos'=>"json",
    ];
    protected $hidden = [
        'original_pass'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }

}
