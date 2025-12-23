<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    //

 protected $guarded = ['id','_token'];

    public function zone()
    {
        return $this->belongsTo('App\Models\Zone');
    }

    public function districts()
    {
        return $this->hasMany('App\Models\District');
    }
}
