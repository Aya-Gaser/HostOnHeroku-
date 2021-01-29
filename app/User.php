<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Permissions\HasPermissionsTrait;

//use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasPermissionsTrait; //Import The Trait

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function projects(){
        return $this->hasMany('App\projects',['translator_id','editor_id','created_by_id']);
    }
    public function WO(){
        return $this->hasMany('App\WO','wo_id');
    }
    public function editingDetails(){
        return $this->hasMany('App\editingDetails','editor_id');
     }
    public function vendorDelivery(){
    return $this->hasMany('App\vendorDelivery','vendor_id');
    }
   
}
