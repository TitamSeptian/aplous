<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
	use softDeletes;
	
    protected $dates = ['deleted_at'];
    protected $table = 'tb_member';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function transaksi()
    {
    	return $this->hasMany(Transaksi::class);
    }
}
