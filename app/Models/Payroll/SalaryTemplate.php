<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryTemplate extends Model
{
    use HasFactory;

    protected $table = "tbl_salary_template";

    protected $primaryKey = 'salary_template_id';

    protected $fillable = ['salary_template_id','salary_grade','basic_salary','overtime_salary','user_id'];

    public function employeePayroll(){

        return $this->hasMany('App\Models\Payroll\EmployeePayroll','salary_template_id');
    }
}
