<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $table = "tbl_transfer";

      protected $guarded = ['id','_token'];

        public function chart_from()
    {
        return $this->hasOne(ChartOfAccount::class, 'id', 'from_account_id');
    }
   public function chart_to()
    {
        return $this->hasOne(ChartOfAccount::class, 'id', 'to_account_id');
    }

}
