<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table = "tbl_currencies";

    public $timestamps = false;
    

       
     public function userdetails()
    {
         return $this->hasMany('App\Models\UserDetails','code');
    }


}