<?php

namespace App\Models\Cotton;

use Illuminate\Database\Eloquent\Model;

class AssignDriver extends Model
{
    protected $table = "assign_driver";

      protected $guarded = ['id','_token'];

        public function driver()
    {
        return $this->belongsTo('App\Models\Truck', 'driver_id');
    }


}
