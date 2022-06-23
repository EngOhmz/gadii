<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    //

 protected $guarded = ['id','_token'];
    
    public function region()
    {
        return $this->belongsTo('App\Models\Region','region_id');
    }
}
