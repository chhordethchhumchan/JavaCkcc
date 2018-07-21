<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;


class User extends Authenticatable
{
    use HasApiTokens,Notifiable,EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    
    protected $fillable = [

        'name', 'email','phone','address','city','password','age','sex','record_status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function AauthAcessToken(){
        return $this->hasMany('\App\OauthAccessToken');
    }

    /**
     * Get the texts of user.
     */
    public function texts()
    {
        return $this->hasMany('App\Text');
    }

    /**
     * Get the pictures of user.
     */
    public function pictures()
    {
        return $this->hasMany('App\Picture');
    }

    /**
     * Get the videos of user.
     */
    public function videos()
    {
        return $this->hasMany('App\Video');
    }

    /**
     * Get the Diabetes Record of user.
     */
    public function DiabeteRecords()
    {
        return $this->hasMany('App\DiabeteRecord');
    }

}
