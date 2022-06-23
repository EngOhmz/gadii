<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryAllowance extends Model
{
    use HasFactory;

    protected $table = "tbl_salary_allowance";
    protected $fillable = ['salary_allowance_id','salary_template_id','allowance_label','allowance_value','user_id'];

 
}

