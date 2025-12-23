<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class  EmployeeLoanReturn extends Model
{
    use HasFactory;

 protected $table = "tbl_employee_loan_returns";

 protected $guarded = ['id','_token'];


  public function user(){
    
        return $this->belongsTo('App\Models\User','user_id');
      }
}
