<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethode extends Model
{
    use HasFactory;

    protected $table = "tbl_payment_methods";
}
