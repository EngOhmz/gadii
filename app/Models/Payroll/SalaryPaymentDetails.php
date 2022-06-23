<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryPaymentDetails extends Model
{
    use HasFactory;

    protected $table = "tbl_salary_payment_details";

    protected $fillable = ['salary_payment_id','salary_payment_details_label','salary_payment_details_value'];
}

