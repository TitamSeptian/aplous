<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TbUser extends Model
{
    protected $table = 'tb_user';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
