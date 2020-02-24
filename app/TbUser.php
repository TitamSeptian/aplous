<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TbUser extends Model
{
    protected $table = 'tb_user';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function user()
    {
    	return $this->belongsTo(User::class, 'id_user');
    }

    public function outlet()
    {
    	return $this->belongsTo(Outlet::class, 'id_outlet');
    }

    public function transaksi()
    {
    	return $this->hasMany(Transaksi::class);
    }
}
