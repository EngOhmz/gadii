<?php

namespace App\Models\Tyre;

use Illuminate\Database\Eloquent\Model;

class TyreAssignment extends Model
{
    protected $table = "tyre_assignment";

      protected $guarded = ['id','_token'];

         public function truck()
    {
        return $this->belongsTo('App\Models\Truck', 'truck_id');
    }

  public function tyre()
    {
        return $this->belongsTo('App\Models\Tyre\Tyre', 'tyre_id');
    }

  public function mechanical()
    {
        return $this->belongsTo('App\Models\FieldStaff', 'staff');
    }


}
