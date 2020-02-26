<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paket extends Model
{
    use softDeletes;
    
    protected $dates = ['deleted_at'];
    protected $table = 'tb_paket';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function jenis()
    {
    	return $this->belongsTo(Jenis::class, 'id_jenis');
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
