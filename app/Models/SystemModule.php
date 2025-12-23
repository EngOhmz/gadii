<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SystemModule extends Model
{
    use SoftDeletes;

    protected $table = 'sys_modules';
   protected $guarded = ['id','_token'];


    public function permissions()
    {
        return $this->hasMany('App\Models\Permission', 'sys_module_id');


    }
}

