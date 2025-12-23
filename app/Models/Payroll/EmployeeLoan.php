<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class  EmployeeLoan extends Model
{
    use HasFactory;

 protected $table = "tbl_employee_loan";

 protected $guarded = ['id','_token'];


  public function user(){
    
        return $this->belongsTo('App\Models\User','user_id');
      }
}
