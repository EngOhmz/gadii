<?php

namespace App\Models\Training;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    protected $table = "tbl_training";

protected $guarded = ['id','_token'];
    

    public function  staff(){
    
        return $this->belongsTo('App\Models\user','staff_id');
      }

    


}
