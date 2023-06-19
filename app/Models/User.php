<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;

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
        'status'=>"boolean",
    ];

    public function additionalinfo(){
        return $this->hasOne(UserAdditionals::class,'user_id','id');
    }
    public function products(){
        return $this->hasMany(Products::class,'user_id','id');
    }
    public function removePermission($permission)
    {
        $this->revokePermissionTo($permission);
    }
    public function topayments(){
        return $this->hasMany(Payments::class,'from_id','id');
    }
    public function frompayments(){
        return $this->hasMany(Payments::class,'to_id','id');
    }
    public function viewcount(){
        return $this->hasMany(ViewCounters::class,'element_id','id')->where('type','user');
    }
    
}