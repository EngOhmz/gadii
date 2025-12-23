<?php

namespace App\Models\CF;

use Illuminate\Database\Eloquent\Model;

class CFservice extends Model
{
    protected $table = "tbl_cf_cfservice";

    protected $guarded = ['id'];
    
      public function account()
    {
        return $this->BelongsTo('App\Models\AccountCodes', 'gl_account_id');
    }
    
    
   



}