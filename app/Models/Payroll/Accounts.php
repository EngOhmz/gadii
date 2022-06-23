<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accounts extends Model
{
    use HasFactory;

    protected $table = "tbl_accounts";

    protected $primaryKey = "account_id";

    protected $fillable = ['account_id','account_name','description','balance','account_number','contact_person','contact_phone','bank_details','permission'];
}


