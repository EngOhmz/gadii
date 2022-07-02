<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicePayments extends Model
{
    use HasFactory;

    
    protected $table = "pos_invoice_payments";

    //protected $quarded = ['id','_token'];
    protected $guarded = ['id'];
}

