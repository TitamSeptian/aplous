<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = [
        'id',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function log()
    {
        return $this->hasMany(Log::class);
    }

    public function tbUser()
    {
        return $this->hasOne(TbUser::class, 'id_user');
    }

}
