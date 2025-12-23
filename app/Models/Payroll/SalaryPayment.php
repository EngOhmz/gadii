<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryPayment extends Model
{
    use HasFactory;

    protected $table = "tbl_salary_payments";

    protected $guarded = ['id','_token'];

 public function method(){

        return $this->belongsTo('App\Models\Payment_methodes','payment_type');
    }
  public function account(){

        return $this->belongsTo('App\Models\AccountCodes','account_id');
    }

}


