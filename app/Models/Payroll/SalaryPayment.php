<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryPayment extends Model
{
    use HasFactory;

    protected $table = "tbl_salary_payments";

    protected $fillable = ['salary_payment_id','user_id','payment_month','fine_deduction','payment_type','comments','paid_date','deduct_from','account_id','added_by']; 

 public function method(){

        return $this->belongsTo('App\Models\Payment_methodes','payment_type');
    }
  public function account(){

        return $this->belongsTo('App\Models\AccountCodes','account_id');
    }

}


