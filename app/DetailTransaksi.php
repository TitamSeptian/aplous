<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    protected $table = 'tb_detail_transaksi';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function transaksi()
    {
    	return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    public function paket()
    {
    	return $this->belongsTo(Paket::class, 'id_paket');
    }
}
