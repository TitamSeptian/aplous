<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'tb_transaksi';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function outlet()
    {
    	return $this->belongsTo(Outlet::class, 'id_outlet');
    }

    public function member()
    {
    	return $this->belongsTo(Member::class, 'id_member');
    }

    public function tbUser()
    {
    	return $this->belongsTo(TbUser::class, 'id_user');
    }

    public function detailTransaksi()
    {
    	return $this->hasMany(DetailTransaksi::class);
    }
}
