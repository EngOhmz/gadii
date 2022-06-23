<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryDeduction extends Model
{
    use HasFactory;
    protected $table = "tbl_salary_deduction";
    protected $fillable = ['salary_deduction_id','salary_template_id','deduction_label','deduction_value','user_id'];
}
