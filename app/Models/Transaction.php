<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = "tbl_transactions";

      protected $guarded = ['id','_token'];

        public function chart_from()
    {
        return $this->hasOne(ChartOfAccount::class, 'id', 'account_id');
    }
   public function chart_to()
    {
        return $this->hasOne(ChartOfAccount::class, 'id', 'code_id');
    }

}
