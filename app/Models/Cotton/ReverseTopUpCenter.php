<?php

namespace App\Models\Cotton;

use Illuminate\Database\Eloquent\Model;

class ReverseTopUpCenter extends Model
{
    protected $table = "reversed_top_up_center";

      protected $guarded = ['id','_token'];

        public function chart_from()
    {
        return $this->belongsTo('App\Models\Cotton\CollectionCenter', 'from_account_id');
    }
   public function chart_to()
    {
       return $this->belongsTo('App\Models\Cotton\Operator', 'to_account_id');
    }

}
