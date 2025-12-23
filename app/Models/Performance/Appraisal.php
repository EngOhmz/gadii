<?php

namespace App\Models\Performance;

use Illuminate\Database\Eloquent\Model;

class Appraisal extends Model
{
    protected $table = "tbl_performance_apprisal";

    protected $guarded = ['id'];
    
   
    
    
public function assign()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }


}
