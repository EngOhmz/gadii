<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accounts extends Model
{
    protected $table = "tbl_account_details";

      protected $guarded = ['id','_token'];

        public function chart()
    {
 return $this->belongsTo('App\Models\AccountCodes','account_id');
    }


}
