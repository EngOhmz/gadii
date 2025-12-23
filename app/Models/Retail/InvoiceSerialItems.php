<?php

namespace App\Models\Retail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceSerialItems extends Model
{
    use HasFactory;

    protected $table = "retail_pos_invoice_serial_items";
    protected  $guarded = ['id'];
}
