<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'tb_member';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function transaksi()
    {
    	return $this->hasMany(Transaksi::class);
    }
}
