<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    use HasFactory;

    protected $table = "tbl_overtime";

 protected $guarded = ['id','_token'];


  public function user(){
    
        return $this->belongsTo('App\Models\User','user_id');
      } 

}
