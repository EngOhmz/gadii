<?php

namespace App\Models\Pharmacy\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItems1 extends Model
{
    use HasFactory;

    protected $table = "pharmacy_pos_invoice_items1";
    protected  $guarded = ['id'];
}
