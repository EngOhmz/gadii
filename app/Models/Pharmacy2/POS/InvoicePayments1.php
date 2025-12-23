<?php

namespace App\Models\Pharmacy\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicePayments1 extends Model
{
    use HasFactory;

    
    protected $table = "pharmacy_pos_invoice_payments1";

    //protected $quarded = ['id','_token'];
    protected $guarded = ['id'];
}

