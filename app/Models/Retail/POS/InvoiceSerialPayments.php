<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class  InvoiceSerialPayments extends Model
{
    use HasFactory;

    
    protected $table = "pos_serial_invoice_payments";

    //protected $quarded = ['id','_token'];
    protected $guarded = ['id'];
}

