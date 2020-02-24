<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    protected $table = 'tb_outlet';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
