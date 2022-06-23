<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryPaymentAllowance extends Model
{
    use HasFactory;

    protected $table = "tbl_salary_payment_allowance";


    protected $fillable = ['salary_payment_id','salary_payment_allowance_label','salary_payment_allowance_value'];
}
