<?php

namespace App\Models\Cotton;

use Illuminate\Database\Eloquent\Model;

class TopUpCenter extends Model
{
    protected $table = "top_up_center";

      protected $guarded = ['id','_token'];

        public function chart_from()
    {
        return $this->belongsTo('App\Models\Cotton\Operator', 'from_account_id');
    }
   public function chart_to()
    {
       return $this->belongsTo('App\Models\Cotton\CollectionCenter', 'to_account_id');
    }

}
