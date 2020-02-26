<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jenis extends Model
{
	// softdelete
	use softDeletes;


    protected $dates = ['deleted_at'];
    protected $table = 'jenis';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function paket()
    {
    	return $this->hasMany(Paket::class);
    }
}
