<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Outlet extends Model
{
    use softDeletes;
    
    protected $dates = ['deleted_at'];
    protected $table = 'tb_outlet';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function paket()
    {
    	return $this->hasMany(Paket::class, 'id_outlet');
    }

    public function tbUser()
    {
    	return $this->hasMany(TbUser::class, 'id_outlet');
    }

    public function transaksi()
    {
    	return $this->hasMany(Transaksi::class, 'id_outlet');
    }

    public function pengeluaran()
    {
        return $this->hasMany(Pengeluaran::class, 'id_outlet');
    }

}
