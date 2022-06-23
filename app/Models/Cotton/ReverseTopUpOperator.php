<?php

namespace App\Models\Cotton;

use Illuminate\Database\Eloquent\Model;

class ReverseTopUpOperator extends Model
{
    protected $table = "reversed_top_up_operator";

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
