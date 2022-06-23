<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeePayroll extends Model
{
    use HasFactory;

    protected $table = "tbl_employee_payroll";

    protected $fillable = ['payroll_id','salary_template_id','added_by','user_id','department_id'];

    public function salaryTemplates(){

        return $this->belongsTo('App\Models\Payroll\SalaryTemplate','salary_template_id');
    }
  public function user(){

        return $this->belongsTo('App\Models\User','user_id');
    }
}
