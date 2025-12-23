<?php

namespace App\Models\UserDetails;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryDetails extends Model
{
    use HasFactory;
    protected $table = "user_salary_details";
     protected $guarded = ['id'];
}
