<?php

namespace App\Models\Bar\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnInvoicePayments extends Model
{
    use HasFactory;
    protected $table = "store_pos_return_invoice_payments";

    protected $guarded = ['id'];
}
