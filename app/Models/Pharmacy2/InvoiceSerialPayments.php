<?php

namespace App\Models\Pharmacy ;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceSerialPayments extends Model
{
    use HasFactory;

    
    protected $table = "pharmacy_pos_invoice_serial_payments";

    //protected $quarded = ['id','_token'];
    protected $guarded = ['id'];
}

