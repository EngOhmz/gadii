<?php

namespace App\Models\School;

use Illuminate\Database\Eloquent\Model;

class SchoolBreakdown extends Model
{
    protected $table = "school_fees_breakdown";

      protected $guarded = ['id','_token'];

 public function name(){
    
        return $this->belongsTo('App\Models\AccountCodes','type');
      }

    

}
