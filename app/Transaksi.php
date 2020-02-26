<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaksi extends Model
{
    use softDeletes;

    protected $dates = ['deleted_at'];
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
