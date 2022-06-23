<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryPaymentDeduction extends Model
{
    use HasFactory;

    protected $table = "tbl_salary_payment_deduction";

    protected $fillable = ['salary_payment_id','salary_payment_deduction_label','salary_payment_deduction_value'];
}
