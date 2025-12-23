<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnInvoiceItems extends Model
{
    use HasFactory;

    protected $table = "pos_return_invoice_items";
    protected  $guarded = ['id'];
}
