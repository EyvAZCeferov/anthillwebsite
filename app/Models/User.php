<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name_surname',
        'email',
        'phone',
        'phone_2',
        'password',
        'is_admin',
        'type',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        "is_admin" => "boolean",
        'status' => "boolean",
    ];

    public function additionalinfo()
    {
        return $this->hasOne(UserAdditionals::class, 'user_id', 'id');
    }
    public function products()
    {
        return $this->hasMany(Products::class, 'user_id', 'id')->orderBy("updated_at",'DESC');
    }
    public function ordersfrom()
    {
        return $this->hasMany(Orders::class, 'from_id', 'id');
    }
    public function ordersto()
    {
        return $this->hasMany(Orders::class, 'to_id', 'id');
    }
    public function message_groups()
    {
        return $this->hasMany(MessageGroups::class, 'receiver_id', 'id');
    }
    public function viewcount(){
        return $this->hasMany(ViewCounters::class,'element_id','id')->where('type','user');
    }
}
