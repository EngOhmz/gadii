<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAward extends Model
{
    use HasFactory;

    protected $table = "tbl_employee_award";

protected $fillable = ['user_id','award_amount','gift_item','award_date','given_date','view_status','award_name','approve_by','added_by']; 
}
