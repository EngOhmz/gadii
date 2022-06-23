<?php

namespace App\Models\Cotton;

use Illuminate\Database\Eloquent\Model;

class TopUpOperator extends Model
{
    protected $table = "top_up_operator";

      protected $guarded = ['id','_token'];

        public function chart_from()
    {
        return $this->hasOne('App\Models\ChartOfAccount::class', 'id', 'from_account_id');
    }
   public function chart_to()
    {
        return $this->belongsTo('App\Models\Cotton\Operator', 'to_account_id');
    }

}
