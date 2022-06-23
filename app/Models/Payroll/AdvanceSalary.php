<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvanceSalary extends Model
{
    use HasFactory;

 protected $table = "tbl_advance_salary";

protected $fillable = ['user_id','advance_amount','deduct_month','reason','request_date','status','approve_by','added_by']; 

 public function designation(){
    
        return $this->belongsTo('App\Models\Designation','designation_id');
      }
  public function department(){
    
        return $this->belongsTo('App\Models\Departments','department_id');
      }
  public function user(){
    
        return $this->belongsTo('App\Models\User','user_id');
      }
}
