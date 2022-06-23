<?php

namespace App\Models\Cotton;

use Illuminate\Database\Eloquent\Model;

class ReverseAssignCenter extends Model
{
    protected $table = "reversed_assign_center";

      protected $guarded = ['id','_token'];

        public function driver()
    {
        return $this->belongsTo('App\Models\Cotton\CollectionCenter', 'driver_id');
    }


}
