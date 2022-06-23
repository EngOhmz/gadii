<?php

namespace App\Models\Cotton;

use Illuminate\Database\Eloquent\Model;

class CottonLevyMovement extends Model
{
    protected $table = "cotton_movement_levy";

      protected $guarded = ['id','_token'];

        public function chart_to()
    {
        return $this->belongsTo('App\Models\ChartOfAccount', 'to_account_id');
    }
   public function chart_from()
    {
        return $this->belongsTo('App\Models\Cotton\Operator', 'from_account_id');
    }

}
