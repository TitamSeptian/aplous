<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    protected $table = 'tb_paket';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
