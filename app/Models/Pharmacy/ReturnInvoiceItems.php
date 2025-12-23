<?php

namespace App\Models\Pharmacy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnInvoiceItems extends Model
{
    use HasFactory;

    protected $table = "pharmacy_pos_return_invoice_items";
    protected  $guarded = ['id'];
}
