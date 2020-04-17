<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengeluaran extends Model
{
    use softDeletes;
    
    protected $dates = ['deleted_at'];
    protected $table = 'pengeluaran';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function outlet()
    {
    	return $this->belongsTo(Outlet::class, 'id_outlet');
    }
}
