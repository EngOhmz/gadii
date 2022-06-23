<?php

namespace App\Models\Tyre;

use Illuminate\Database\Eloquent\Model;

class  TruckTyre extends Model
{
    protected $table = "truck_tyre";

      protected $guarded = ['id','_token'];

        public function truck()
    {
        return $this->belongsTo('App\Models\Truck', 'truck_id');
    }

  public function mechanical()
    {
        return $this->belongsTo('App\Models\FieldStaff', 'staff');
    }

}
