<?php

namespace App\Models\Cotton;

use Illuminate\Database\Eloquent\Model;

class ReverseAssignDriver extends Model
{
    protected $table = "reversed_assign_driver";

      protected $guarded = ['id','_token'];

        public function driver()
    {
        return $this->belongsTo('App\Models\Driver', 'driver_id');
    }


}
