<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class  EmployeeLoan extends Model
{
    use HasFactory;

 protected $table = "tbl_employee_loan";

protected $fillable = ['user_id',
'loan_amount',
'paid_amount',
'sponsor',
'deduct_month',
'reason',
'request_date',
'status',
'returns',
'approve_by',
'added_by'

]; 


  public function user(){
    
        return $this->belongsTo('App\Models\User','user_id');
      }
}
