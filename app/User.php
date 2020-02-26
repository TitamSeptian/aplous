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
        return $this->belongsTo(Log::class);
    }

    public function tbUser()
    {
        return $this->hasMany(TbUser::class, 'id_user');
    }

    public function admin()
    {
        return $this->hasMany(TbUser::class);
    }
}
