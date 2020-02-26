<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailTransaksi extends Model
{
    use softDeletes;
    
    protected $dates = ['deleted_at'];
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
