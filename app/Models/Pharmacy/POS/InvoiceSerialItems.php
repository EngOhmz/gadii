<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceSerialItems extends Model
{
    use HasFactory;

    protected $table = "pos_serial_invoices_items";
    protected  $guarded = ['id'];
}
