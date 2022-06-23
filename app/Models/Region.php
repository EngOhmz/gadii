<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    //
    public function zone()
    {
        return $this->belongsTo('App\Models\Zone');
    }

    public function districts()
    {
        return $this->hasMany('App\Models\District');
    }
}
