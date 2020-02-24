<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    protected $table = 'tb_outlet';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function paket()
    {
    	return $this->hasMany(Paket::class);
    }

    public function tbUser()
    {
    	return $this->hasMany(TbUser::class);
    }

    public function transaksi()
    {
    	return $this->hasMany(Transaksi::class);
    }
}
