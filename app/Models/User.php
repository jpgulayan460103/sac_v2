<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    public static function boot() {
        parent::boot();
    
        static::creating(function (User $item) {
            $item->name = "$item->first_name $item->middle_name $item->last_name";
        });
    
        static::updating(function (User $item) {
            $item->name = "$item->first_name $item->middle_name $item->last_name";
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'confirmed',
        'role',
        'position',
        'first_name',
        'middle_name',
        'last_name',
        'barangay_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function findForPassport($username){
        return $this->where('username', $username)->first();
    }

    public function AauthAcessToken(){
        return $this->hasMany('\App\Models\OauthAccessToken');
    }

    public function barangay()
    {
        return $this->belongsTo('App\Models\Barangay');
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        // 'email_verified_at' => 'datetime',
    ];
}
