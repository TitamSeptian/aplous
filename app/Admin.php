<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admins';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
