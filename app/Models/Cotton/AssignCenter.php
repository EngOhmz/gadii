<?php

namespace App\Models\Cotton;

use Illuminate\Database\Eloquent\Model;

class AssignCenter extends Model
{
    protected $table = "assign_center";

      protected $guarded = ['id','_token'];

        public function driver()
    {
        return $this->belongsTo('App\Models\Cotton\CollectionCenter', 'driver_id');
    }


}
