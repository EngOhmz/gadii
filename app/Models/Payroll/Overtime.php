<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    use HasFactory;

    protected $table = "tbl_overtime";

protected $fillable = ['user_id','overtime_date','overtime_amount','notes','status','approve_by','added_by']; 


  public function user(){
    
        return $this->belongsTo('App\Models\User','user_id');
      } 

}
