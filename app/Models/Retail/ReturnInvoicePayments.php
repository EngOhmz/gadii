<?php

namespace App\Models\Retail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnInvoicePayments extends Model
{
    use HasFactory;

    
    protected $table = "retail_pos_return_invoice_payments";

    //protected $quarded = ['id','_token'];
    protected $guarded = ['id'];
}

