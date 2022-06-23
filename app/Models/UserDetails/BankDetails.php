<?php

namespace App\Models\UserDetails;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankDetails extends Model
{
    use HasFactory;
    protected $table = "bank_details";
    protected $fillable = ['account_name','user_id','bank_name','routing_number','account_number'];
}
